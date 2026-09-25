<?php

	namespace Functions;
	use Tools\Connectivity\DatabaseEMan;
	use Tools\Connectivity\DatabaseEMan2;
	use Tools\Connectivity\DatabaseIncusadmin;
	use Tools\helper;
	
	//email
	use Functions\SendSMTP;
	
	class EManCCNFunc{
		
		private $connection1;
		private $connection2;
		private $helper;
		private $SMTP;
		
		public function __construct(){
		
			$this->connection1 = new DatabaseEMan;
			$this->connection2 = new DatabaseEMan2;
			$this->connection3 = new DatabaseIncusadmin;
			$this->helper = new helper;
			$this->SMTP = new SendSMTP;
			
		}
		
		public function getPlaceLoading(){
		
			$query = " SELECT * FROM tblPlaceLoading";
			return $this->connection1->query($query);	
		
		}

		public function saveFlightResgitry($FlightNo, $Registryno, $ETA){

			//foreach ($data as $k => $v) {

			 	//print_r(implode(',',array_keys($v)));
		        $sql = "INSERT INTO MANIFESTFLIGHT (FlightNo, ETA, Registryno) VALUES(?, ?, ?)";

		        $params = array($FlightNo, $ETA, $Registryno);

			  $stmt = $this->connection1->query_data($sql, $params);
		    //}

		}
		
		public function GETCarrierInfo($CarrierCd){
			
			$sql = "SELECT     TOP (1) Code, Name, Addr1, Addr2, Addr3, Addr4, GuidComb
					FROM         GBCARTAB
					WHERE     (Code = ?)";
			$params = array($CarrierCd);
					
			$stmt = $this->connection2->query_data($sql, $params);

			$rowCount = abs($this->connection2->queryCount($stmt));
			
			//echo $rowCount;
			$data = null;	
			if($rowCount > 0){
				
				$data = $this->connection2->fetchAll($stmt);

				
			}
			
			return $data;
			
		}
		public function GETCtyInfo($cty_cod){
			
			$sql = "SELECT     TOP (1) cty_cod, cty_dsc, rul_cod, lst_ope, ser_sta
					FROM         GBCTYTAB
					WHERE     (cty_cod = ?)";
			$params = array($cty_cod);
					
			$stmt = $this->connection2->query_data($sql, $params);

			$rowCount = abs($this->connection2->queryCount($stmt));
			
			//echo $rowCount;
			$data = null;	
			if($rowCount > 0){
				
				$data = $this->connection2->fetchAll($stmt);

				
			}
			
			return $data;
			
		}
		
		public function checkifDuplicateGEN($RegNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival){
			
			//checkifDuplicates
			$sql = "SELECT     TOP (1) ApplNo, Registryno, BOCOFC
				FROM         MANIFESTGEN WHERE Registryno = ? AND BOCOFC = ? AND ArrivalDate = ? AND ArrivalTime = ?";
			$params = array($RegNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival);
					
			$stmt = $this->connection1->query_data($sql, $params);

			$rowCount = abs($this->connection1->queryCount($stmt));
			
			//echo $rowCount;
					
			if($rowCount > 0){
				
				return true;
				
			}else{
				return false;
			}
			
		}
		
		public function GetApplNo($RegNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival){
			
			//checkifDuplicates
			$sql = "SELECT     TOP (1) ApplNo, Registryno, BOCOFC
				FROM         MANIFESTGEN WHERE Registryno = ? AND BOCOFC = ? AND ArrivalDate = ? AND ArrivalTime = ?";
			$params = array($RegNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival);
					
			$stmt = $this->connection1->query_data($sql, $params);

			$rowCount = abs($this->connection1->queryCount($stmt));
			
			//echo $rowCount;
			$data = null;
			if($rowCount > 0){
				
				$data = $this->connection1->fetchAll($stmt);
				
			}
			
			return $data;
			
		}
		
		public function checkifDuplicateBOL($AWBReference, $BLCustoms_office_segment, $RegNo){
			
			//checkifDuplicates
			$sql = "SELECT     TOP (1) ApplNo, Registryno, BLNo 
				FROM         MANIFESTBOL WHERE BLNo = ? AND BOCOFC = ? AND RegistryNo = ?";
			$params = array($AWBReference, $BLCustoms_office_segment, $RegNo);
					
			$stmt = $this->connection1->query_data($sql, $params);

			$rowCount = abs($this->connection1->queryCount($stmt));
			
			//echo $rowCount;
					
			if($rowCount > 0){
				
				return true;
				
			}else{
				return false;
			}
			
		}
		
		public function ManifestGen($ApplNo, $RegNo, $Customs_office_segment, $status, $Last_Date_Departure, $Date_of_arrival, $Time_of_arrival, $DepLCode, $DesLCode, $CSCode, $CSName, $CSAddress1, $CSAddress2, $CSAddress3, $CSAddress4, $ModeTS, $NationalTS, $Place_of_transporter, $Registration_number, $Registration_date, $FlightNo, $Net_tonnage, $Gross_tonnage, $NumberofBL, $Total_containers, $cltcode, $cdate, $userid, $auto_upload_status){
			
			//checkifDuplicates
			$sql = "INSERT INTO MANIFESTGEN (ApplNo, Registryno, BOCOFC, STATUS, DischargeDate, ArrivalDate, ArrivalTime, PLDeparture, PLDestination, CarrierCode, CarrierName, CarrierAdd1, CarrierAdd2, CarrierAdd3, CarrierAdd4, Transportmode, TransportID, TransportNationality, PlTransportReg, TransportRegNo, TransportRegDate, VoyageNo, CountryOrg, NetTonnage, GrossTonnage, NumberofBL, TotalContainers, cltcode, CreationDate, Filename, userid) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$params = array($ApplNo, $RegNo, $Customs_office_segment, $status, $Last_Date_Departure, $Date_of_arrival, $Time_of_arrival, $DepLCode, $DesLCode, $CSCode, $CSName, $CSAddress1, $CSAddress2, $CSAddress3, $CSAddress4, $ModeTS, $FlightNo, $NationalTS, $Place_of_transporter, $Registration_number, $Registration_date, $FlightNo, $NationalTS, $Net_tonnage, $Gross_tonnage, $NumberofBL, $Total_containers, $cltcode, $cdate, $auto_upload_status, $userid); 
					
			$stmt = $this->connection1->query_data($sql, $params);
			
			return "\n\n $ApplNo - Successfully Save Record to ManifestGen Table\n\n";
		}
		
		public function ManifestBOL($ApplNo, $RegNo, $BLCustoms_office_segment, $status, $Line_number, $AWBReference, $BLStatus, $AWBType, $AWB_Nature, $Unique_carrier_reference, $SName, $SAddress1, $SAddress2, $SAddress3, $SAddress4, $CName, $CAddress1, $CAddress2, $CAddress3, $CAddress4, $NName, $NAddress1, $NAddress2, $NAddress3, $NAddress4, $Place_of_loading_segment, $Place_of_unloading_segment, $Package_type_code, $Number_of_packages, $Total_gross_mass_manifested, $Volume_in_cubic_meters, $Marking1, $Goods1, $FreightAmount, $Currency, $InsuranceAmount, $DefaultVal, $cltcode, $cdate, $LGoods, $userid, $FreightInd, $auto_upload_status){
			
			//checkifDuplicates
			$sql = "INSERT INTO MANIFESTBOL (ApplNo, RegistryNo, BOCOFC, Status, BLNo, BLLineNo, BLStatus, BLType, BLNatureCode, UniqueRefno, Exportername,ExporterAdd1,ExporterAdd2,ExporterAdd3,ExporterAdd4,ConsigneeName,ConsigneeAdd1,ConsigneeAdd2,ConsigneeAdd3,ConsigneeAdd4,NotifyName,NotifyAdd1,NotifyAdd2,NotifyAdd3,NotifyAdd4,PLDeparture,PLDestination,PackCode,PackNo,GrossMass,Measurement,ShippingMarks1,GoodsDesc1, FreightInd,FreightVal,FreightCur, CustomsVal, CustomsCur, TransportVal, TransportCur,InsuranceVal,InsuranceCur, cltcode, CreationDate, LGoods, Filename, userid) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?, ?, ? ,?, ?, ?, ?, ?, ?)";
					
			$params = array($ApplNo, $RegNo, $BLCustoms_office_segment, $status, $AWBReference, $Line_number, $BLStatus, $AWBType, $AWB_Nature, $Unique_carrier_reference, $SName, $SAddress1, $SAddress2, $SAddress3, $SAddress4, $CName, $CAddress1, $CAddress2, $CAddress3, $CAddress4, $NName, $NAddress1, $NAddress2, $NAddress3, $NAddress4, $Place_of_loading_segment, $Place_of_unloading_segment, $Package_type_code, $Number_of_packages, $Total_gross_mass_manifested, $Volume_in_cubic_meters, $Marking1, $Goods1, $FreightInd, $FreightAmount, $Currency, $DefaultVal, $Currency, $DefaultVal, $Currency, $InsuranceAmount, $Currency, $cltcode, $cdate, $LGoods, $auto_upload_status, $userid); 
			
			$stmt = $this->connection1->query_data($sql, $params);
			
			
			return "\n\n $Line_number. BLNo[$AWBReference] - Successfully Save Record to ManifestBOL Table\n\n";
		}
		
		public function GetUser($SenderIATAID){
			
			$sql = "SELECT     TOP (1) id, username, email, account, password, salt, pw, CarrierCode
					FROM         users WHERE CarrierCode = ?";
			$params = array($SenderIATAID);
					
			$stmt = $this->connection1->query_data($sql, $params);

			$rowCount = abs($this->connection1->queryCount($stmt));
			
			//echo $rowCount;
			$data = null;	
			if($rowCount > 0){
				
				$data = $this->connection1->fetchAll($stmt);

				
			}
			
			return $data;
			
		}
		
		public function SendEmailNotification($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage){
			
			if ($this->SMTP->privateMessage_cc($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage, $altMessageBody=null)){
				echo "success SendEmailNotification \r\n";
				return true;
			}else{
				echo "error SendEmailNotification \r\n";
				return false;
			}
		}
		
		public function SendEmailNotificationDGF($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage){
			
			if ($this->SMTP->privateMessage_DGF($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage, $altMessageBody=null)){

				return true;
			}else{

				return false;
			}
		}
		
		public function sendEmailErrGEN($recepientEmail, $CC, $BCC, $errCCN, $DBErr, $RegNo, $filename){
			

			//$recepientEmail = 'nkoriel@intercommerce.com.ph';
			$recepientName = 'INS';
			
			/*$subject = "e-MANIFEST WEB MAILER: YOUR XML FILE WAS PROCESSED WITH ERROR";
			
			$htmlMessage = "<p>We have processed your file and we encountered some missing information. Please input the necessary information and submit for processing by accessing your account in the <a href='http://manifest.intercommerce.com.ph'>eManifest web site</a></p>";
			$htmlMessage .= "<br />";
			
			$errDataGen = $errCCN[0];
			$errDataBol = $errCCN[1];
			
			$ApplNo = isset($errDataGen[0]) ? $errDataGen[0] : '';
			$errGenDetails = isset($errDataGen[1]) ? $errDataGen[1] : array();
			
			$htmlMessage .= "<p>Application No: ".$ApplNo."</p>";
			$htmlMessage .= "<br />";
			$htmlMessage .= "<p style='font-style:italic;'>For Manifest</p>";
			$htmlMessage .= "<p>Missing Information:</p>";
			
			$counter = 1;
			foreach($errGenDetails as $errGen){
				$htmlMessage .= "<p style='color:#F00'>".$counter.". ".$errGen."</p>";
				$counter++;
			}
			
			$htmlMessage .= "<br />";
			
			if( count($errDataBol) > 0 ){
				
				$htmlMessage .= "<p style='font-style:italic;'>For BOL</p>";
			
				foreach($errDataBol as $errBol){
					
					$BLNo = $errBol[0];
					$htmlMessage .= "<p>BL No: ".$BLNo."</p>";
					$htmlMessage .= "<p>Missing Information:</p>";
					
					$counter = 1;
					foreach($errBol[1] as $errBolDetails){
						$htmlMessage .= "<p style='color:#F00'>".$counter.". ".$errBolDetails."</p>";
						$counter++;
					}
					
					$htmlMessage .= "<br />";
				}
			}
			
			$htmlMessage .= "<p style='font-weight:bold'>IMPORTANT:</p>";
			$htmlMessage .= "<p>If you have further concerns or clarification, please do not hesitate to call or email us.</p>";
			$htmlMessage .= "<p>Have a nice day.</p>";
			$htmlMessage .= "<p>Thank you!</p>";
			$htmlMessage .= "<br />";
			$htmlMessage .= "<p>INS Administrator</p>";

			
			//die($htmlMessage);
			*/
			
			//print_r($errCCN);
			//print_r($DBErr);
			//die();
			
			$subject = "e-MANIFEST ALERT: Auto Processing of ".$RegNo." STATUS: ERROR";
			
			$htmlMessage = '<p>The system has just processed your file <i>'.$filename.'</i> but encountered an ERROR see below for the details.<br />';
			//$htmlMessage .= '<br />';
			$ApplNo = '';
			if( count($errCCN) > 0){
				
				$counter = 0;
				
				$htmlMessage .= '<br /><br />MANIFEST XML ERROR<br /><br />';
				
				
				foreach($errCCN as $xml_err){
					if(count($xml_err) > 0){
						if($counter == 0){
							$ApplNo = $xml_err[0];
							$htmlMessage .= '<br />Application No: '.$ApplNo;
							$htmlMessage .= '<br />';
							$htmlMessage .= 'Registry Number: '. $RegNo;
							$htmlMessage .= '<br />';
							$htmlMessage .= 'Status: Error - Missing Information';
							$htmlMessage .= '<br />';
							$htmlMessage .= '<i>Manifest Fields: </i>';
							$htmlMessage .= '<br />';
							
							$ctr = 1;
							foreach($xml_err[1] as $gen_xml){
								$htmlMessage .= $ctr.'. '.$gen_xml;
								$htmlMessage .= '<br />';
								$ctr++;
							
							}
							
							
						}
						elseif($counter == 1){
							
							foreach($xml_err as $bol_err){
							
								$htmlMessage .= '<br />Application No: '.$ApplNo;
								$htmlMessage .= '<br />';
								$htmlMessage .= 'Registry Number: '. $RegNo;
								$htmlMessage .= '<br />';
								$htmlMessage .= 'BL Number: '.$bol_err[0];
								$htmlMessage .= '<br />';
								$htmlMessage .= 'Status: Error - Missing Information';
								$htmlMessage .= '<br />';
								$htmlMessage .= '<i>Manifest Fields: </i>';
								$htmlMessage .= '<br />';
								
								
								$ctr = 1;
								foreach($bol_err[1] as $bol_xml){
									$htmlMessage .= $ctr.'. '.$bol_xml;
									$htmlMessage .= '<br />';
									$ctr++;
								}
								
							}
							
						}
					}
					$counter++;
				}
				
				
				
			}
			
			if( count($DBErr) > 0 ){
				$dbctr = 0;
				
				$htmlMessage .= '<br /><br />MANIFEST DATABASE ERROR<br /><br />';
				
				foreach($DBErr as $db_err){
					if($dbctr == 0){
						foreach($db_err as $dbErrdetails){
							$htmlMessage .= "- ". $dbErrdetails;
							$htmlMessage .= '<br />';
						}
					}else{
						
						foreach($db_err as $dbErrdetails){
							$htmlMessage .= "- ". $dbErrdetails;
							$htmlMessage .= '<br />';
						}
					}
										
					$dbctr++;
				}
			}
			
			
			$htmlMessage .= " <br /><br />
							Login to <a href='http://manifest.intercommerce.com.ph/'>eManifest web site</a>, to view the details, complete the information and to submit the application to BOC for processing.<br />
							 <br />
							Note:<br />
							For further assistance, please call 02-7521188 or email us at helpdesk@intercommerce.com.ph.<br />
							 <br />
							Thank you.<br />
							InterCommerce Network Services, Inc.<br />
							(DO NOT REPLY. This is an auto-generated email)</p>";
			
			
			//die($htmlMessage);
			
			
			if ($this->SMTP->privateMessage_cc($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage, $altMessageBody=null)){

				return true;
			}else{

				return false;
			}
			
		}
		
		
		public function sendEmailSuccess($recepientEmail, $CC, $BCC, $RegNo, $ApplNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival, $Total_number_of_mawb, $filename){
			
			
			$recepientName = 'INS';
			
			
			$subject = "e-MANIFEST ALERT: Auto Processing of ".$RegNo." STATUS: SUCCESS";
			
			$htmlMessage = '<p>The system has just processed your file <i>'.$filename.'</i>.<br />';
			
			$htmlMessage .= '<br /><br />MANIFEST BASIC INFORMATION<br /><br />';
				
			$htmlMessage .= '<br />Application No: '.$ApplNo;
			$htmlMessage .= '<br />';
			$htmlMessage .= 'Registry Number: '. $RegNo;
			$htmlMessage .= '<br />';
			$htmlMessage .= 'Port: '. $Customs_office_segment;
			$htmlMessage .= '<br />';
			$htmlMessage .= 'Arrival Date: '. $Date_of_arrival;
			$htmlMessage .= '<br />';
			$htmlMessage .= 'Arrival Time: '. $Time_of_arrival;
			$htmlMessage .= '<br />';
			$htmlMessage .= 'Total BOL: '. $Total_number_of_mawb;
			$htmlMessage .= '<br />';
			$htmlMessage .= '<br />';
							
			
			
			$htmlMessage .= " <br /><br />
							Login to <a href='http://manifest.intercommerce.com.ph/'>eManifest web site</a> to view the details.<br />
							 <br />
							Note:<br />
							For further assistance, please call 02-7521188 or email us at helpdesk@intercommerce.com.ph.<br />
							 <br />
							Thank you.<br />
							InterCommerce Network Services, Inc.<br />
							(DO NOT REPLY. This is an auto-generated email)</p>";
			
			
			//die($htmlMessage);
			
			
			if ($this->SMTP->privateMessage_cc($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage, $altMessageBody=null)){

				return true;
			}else{

				return false;
			}
			
		}
		
		public function getManifestGenPort($ApplNo, $RefNo)
		{
			$sql = "SELECT     TOP (1) BOCOFC
				FROM         MANIFESTGEN WHERE Registryno = ? AND ApplNo = ?";
			$params = array($RefNo, $ApplNo);
					
			$stmt = $this->connection1->query_data($sql, $params);

			$rowCount = abs($this->connection1->queryCount($stmt));
			
			//echo $rowCount;
			$data = null;
			if($rowCount > 0){
				
				$data = $this->connection1->fetchAll($stmt);
				
			}
			
			return $data;
		}

		public function updateManifestGENTotalBOL($ApplNo, $RegistryNo, $TotalBL)
		{
			$query = "UPDATE MANIFESTGEN SET NumberofBL = '$TotalBL' WHERE ApplNo = '$ApplNo' AND RegistryNo = '$RegistryNo'";

			if ($this->connection1->exec($query)) {
				return true;
			} else {
				return false;
			}
		}

	}
	
?>
