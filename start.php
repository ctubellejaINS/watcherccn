<?php
require("../../library.php"); // created by drenyl

use Functions\ScanManifestScheduler;
use Functions\HBL;
use Functions\EManCashAdvFunc;
use Functions\XML;
use Functions\Properties;
use Functions\FunctionBOL;
use Functions\CTSFunc;

set_include_path(get_include_path() . PATH_SEPARATOR . '../../plugins');
include('Net/SFTP.php');

$sftp  = new Net_SFTP('192.168.1.239');    // IN dir
$sftp2 = new Net_SFTP('192.168.1.239'); // conf dir

$now             = new DateTime();
$scan            = new ScanManifestScheduler;
$hbl             = new HBL;
$xml             = new XML;
$bol             = new FunctionBOL;
$properties      = new Properties;
$EManCashAdvFunc = new EManCashAdvFunc;
$CTSFunc         = new CTSFunc;

$now->setTimezone(new DateTimeZone('Asia/Manila'));
$dateNow       = $now->format('Y-m-d H:i:s');
$propertiesDIR = '/conf/';
$remoteDIR     = '/IN/';
$localDIR      = "D:\Messages\ManifestSched";

if (!$sftp->login('abms', 'abms@123')) {
    exit('Login Failed');
}
if (!$sftp2->login('manifest', 'manifest@123')) {
    exit('Login Failed');
}

$cts_parallel_sending = $CTSFunc->getCTSParallelSendingStatus();

echo "\nStarting Application...\n";
echo "\n====================================================\n\n";
echo "Phase 1\nScanning scheduled application...\n";
echo "Clock Time: " . $dateNow . "\n\n";
//Scan all Stored Manifest
$manifest_list = $scan->scanPending($dateNow);
print_r($manifest_list);
//die();
echo "Found " . count($manifest_list) . " scheduled application\n\n";
if (count($manifest_list) > 0) {
    $AMT = $EManCashAdvFunc->EMancharged($manifest_list[0]['userid'], 'FW');
    echo "\n";
    $ManifestStatus = "SUCCESS";
    foreach ($manifest_list as $row) {
        echo "**AppID [$row[ApplNo]]; Scanning BOLs...\n";
        if (substr($row['ApplNo'], 0, 2) == "FW") {
            if ($row['ErrorCancel'] != '1') {
                if (!isset($row['StoredDate']) && !isset($row['ValidatedDate'])) {
                    $file = $hbl->newSchedueleHBLstore($row['BLNo'], $row['ApplNo'], $AMT, $row['userid']);

                    if ($file) {
                        $dateSched = $scan->getScheduleTime($row['ApplNo']);
                        $Datesent  =
                            isset($dateSched[0]['dateToSend']) ? $dateSched[0]['dateToSend'] : date('Y-m-d H:i:s');

                        if ($sftp->put($remoteDIR . $file, file_get_contents($localDIR . $file))) {
                            // update status
                            $bol->updateSentStatustHBL($row['BLNo'], $row['ApplNo'], $Datesent);
                            $bolResult = $bol->newGetHBL($row['BLNo'], $row['ApplNo'], $row['userid']);

                            if (count($bolResult) > 0) {
                                $bolData  = $bolResult[0];
                                $status   = $bolData['STATUS'];
                                $Datesent = $bolData['ScheduleDate'] != NULL ? $bolData['ScheduleDate'] : $Datesent;
                            } else {
                                $status = '';
                            }

                            $bol->saveBolLogs($row['ApplNo'], $Datesent, $status, $row['userid']);

                            // add logs
                            $bol->createScheduleSendLogs($row['ApplNo'], $row['RegistryNo'], $row['Port'], $row['PrevDoc'], $row['BLNo'], "Schedule Sent: For Storing");

                            if (!unlink($localDIR . $file)) {
                                die('error deleting xml file');
                            }
                        } else {
                            echo 'error sending';
                        }

                        echo "Success Sending Bol with Application No of: " . $row['ApplNo'] . "\n";

                        $dateSched = $scan->getScheduleTime($row['ApplNo']);
                        if (!$scan->notifStoredManifestScheduler($row['BLNo'], $row['ApplNo'], $dateSched[0]['dateToSend'], $ManifestStatus)) {
                            echo "Failed to send email\n";
                        }

                        // if ($cts_parallel_sending == 1) {
                            // get cts status
                            $CtsStatus = $bol->getCtsStatus($row['ApplNo'], $row['BLNo']);

                            if ($CtsStatus != 'Submitted') {

                                $createXML = $xml->HblCts($row['BLNo'], $row['ApplNo'], $row['cltcode']); //create xml

                                if ($createXML == 'XML creation failed!') {

                                    echo "Error: Manifest records not found";
                                }

//                                if (!$xml->FTPSending($createXML, $row['cltcode'])) {
//                                    echo 'error sending xml cts';
//                                }

                                $local_file = "C:/PHPWebservices/appins/application/views/ManifestSchedulingTask/ManifestXML/";
                                $local_file = $local_file . $createXML;

                                $cts_sftp = new Net_SFTP('192.168.1.239', 22);

                                if(!$cts_sftp->login('ctstest','cts123$')) {
                                    exit('Login Failed in sftp cts');
                                }

                                $remote_file = '/CTS/' . $createXML;

                                // Delete if exists
                                if ($cts_sftp->file_exists($remote_file)) {
                                    $cts_sftp->delete($remote_file);
                                }

                                if($cts_sftp->put($remote_file, file_get_contents($local_file))) {
//                                    if (!unlink($local_file)) {
//                                        die('error deleting xml file');
//                                    }
                                    echo 'XML sent successfully, local file retained';
                                } else {
                                    echo 'error sending';
                                }
                            }
                        // }
                    }
                }
                if (isset($row['StoredDate']) && !isset($row['ValidatedDate'])) {
                    if ($createproperties = $properties->HBLConfValidate($row['BLNo'], $row['ApplNo'])) {
                        echo "Success Creating Properties Bol with Application No of: " . $row['ApplNo'] . "\n";
                        if ($createXML = $hbl->HBLValidate($row['BLNo'], $row['ApplNo'], $dateNow)) {
                            echo "Success Validating Bol with Application No of: " . $row['ApplNo'] . "\n";
                            $dateSched = $scan->getScheduleTime($row['ApplNo']);
                            if ($sftp2->put($propertiesDIR . $createproperties, file_get_contents($localDIR . $createproperties))) {
                                if (unlink($localDIR . $createproperties)) {
                                    sleep(1);
                                    if ($sftp->put($remoteDIR . $createXML, file_get_contents($localDIR . $createXML))) {
                                        // add logs
                                        $bol->createScheduleSendLogs($row['ApplNo'], $row['RegistryNo'], $row['Port'], $row['PrevDoc'], $row['BLNo'], "Schedule Sent: For Validation");

                                        if (!unlink($localDIR . $createXML)) {
                                            echo 'error deleting xml file';
                                        }
                                    }
                                } else {
                                    echo 'error deleting property file';
                                }
                            } else {
                                echo 'error sending';
                            }
                            if (!$scan->notifValidateManifestSchedule($row['BLNo'], $row['ApplNo'], $dateSched[0]['dateToSend'], $ManifestStatus)) {
                                echo "Failed to send email\n";
                            }
                        }
                    } else {
                        echo "error creating Properties and XML of application: " . $$row['ApplNo'];
                    }
                }
            } else {
                if (!isset($row['StoredDate']) && !isset($row['ValidatedDate'])) {
                    if ($file = $hbl->newSchedueleHBLstore($row['BLNo'], $row['ApplNo'], $AMT, $row['userid'])) {
                        $dateSched = $scan->getScheduleTime($row['ApplNo']);
                        $Datesent  =
                            isset($dateSched[0]['dateToSend']) ? $dateSched[0]['dateToSend'] : date('Y-m-d H:i:s');

                        if ($sftp->put($remoteDIR . $file, file_get_contents($localDIR . $file))) {
                            // update status
                            $bol->updateSentStatustHBL($row['BLNo'], $row['ApplNo'], $Datesent);
                            $bolResult = $bol->newGetHBL($row['BLNo'], $row['ApplNo'], $row['userid']);

                            if (count($bolResult) > 0) {
                                $bolData  = $bolResult[0];
                                $status   = $bolData['STATUS'];
                                $Datesent = $bolData['ScheduleDate'] != NULL ? $bolData['ScheduleDate'] : $Datesent;
                            } else {
                                $status = '';
                            }

                            $bol->saveBolLogs($row['ApplNo'], $Datesent, $status, $row['userid']);

                            // add logs
                            $bol->createScheduleSendLogs($row['ApplNo'], $row['RegistryNo'], $row['Port'], $row['PrevDoc'], $row['BLNo'], "Schedule Sent: For Storing");

                            if (!unlink($localDIR . $file)) {
                                echo 'error deleting xml file';
                            }
                        } else {
                            echo 'error sending';
                        }

                        echo "Success Sending Bol with Application No of: " . $row['ApplNo'] . "\n";

                        $dateSched = $scan->getScheduleTime($row['ApplNo']);
                        if (!$scan->notifStoredManifestScheduler($row['BLNo'], $row['ApplNo'], $dateSched[0]['dateToSend'], $ManifestStatus)) {
                            echo "Failed to send email\n";
                        }

//                        if ($cts_parallel_sending == 1) {
                            // get cts status
                            $CtsStatus = $bol->getCtsStatus($row['ApplNo'], $row['BLNo']);

                            if ($CtsStatus != 'Submitted' && $CtsStatus != 'Sent') {
                                $createXML = $xml->HblCts($row['BLNo'], $row['ApplNo'], $row['cltcode']); //create xml

                                if ($createXML == 'XML creation failed!') {

                                    echo "Error: Manifest records not found";
                                }

//                                if (!$xml->FTPSending($createXML, $row['cltcode'])) {
//                                    echo 'error sending xml cts';
//                                }

                                $local_file = "C:/PHPWebservices/appins/application/views/ManifestSchedulingTask/ManifestXML/";
                                $local_file = $local_file . $createXML;

                                $cts_sftp = new Net_SFTP('192.168.1.239', 22);

                                if(!$cts_sftp->login('ctstest','cts123$')) {
                                    exit('Login Failed in sftp cts');
                                }

                                $remote_file = '/CTS/' . $createXML;

                                // Delete if exists
                                if ($cts_sftp->file_exists($remote_file)) {
                                    $cts_sftp->delete($remote_file);
                                }

                                if($cts_sftp->put($remote_file, file_get_contents($local_file))) {
                                    // if (!unlink($local_file)) {
                                    //     die('error deleting xml file');
                                    // }
                                echo 'XML sent successfully, local file retained';
                                } else {
                                    echo 'error sending';
                                }
                            }
//                        }
                    }
                }
                if (isset($row['StoredDate']) && !isset($row['ValidatedDate'])) {
                    if ($createproperties = $properties->HBLConfValidate($row['BLNo'], $row['ApplNo'])) {
                        echo "Success Creating Properties Bol with Application No of: " . $row['ApplNo'] . "\n";
                        if ($createXML = $hbl->HBLValidate($row['BLNo'], $row['ApplNo'], $dateNow)) {
                            echo "Success Validating Bol with Application No of: " . $row['ApplNo'] . "\n";
                            $dateSched = $scan->getScheduleTime($row['ApplNo']);
                            if ($sftp2->put($propertiesDIR . $createproperties, file_get_contents($localDIR . $createproperties))) {
                                if (unlink($localDIR . $createproperties)) {
                                    sleep(1);
                                    if ($sftp->put($remoteDIR . $createXML, file_get_contents($localDIR . $createXML))) {
                                        // add logs
                                        $bol->createScheduleSendLogs($row['ApplNo'], $row['RegistryNo'], $row['Port'], $row['PrevDoc'], $row['BLNo'], "Schedule Sent: For Validation");

                                        if (!unlink($localDIR . $createXML)) {
                                            echo 'error deleting xml file';
                                        }
                                    }
                                } else {
                                    echo 'error deleting property file';
                                }
                            } else {
                                echo 'error sending';
                            }
                            if (!$scan->notifValidateManifestSchedule($row['BLNo'], $row['ApplNo'], $dateSched[0]['dateToSend'], $ManifestStatus)) {
                                echo "Failed to send email\n";
                            }
                        }
                    } else {
                        echo "error creating Properties and XML of application: " . $$row['ApplNo'];
                    }
                }
            }
        }
    }
} else {
    echo "nothing to do here";
}
