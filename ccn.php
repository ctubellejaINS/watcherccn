<?php

/****
 * IMPORTANT:
 *
 * There are validations for AWB INFO READING
 * -multiple BL
 * -single BL
 ***/


require("../../library.php");

use Functions\EManCCNFunc;
use Tools\helper;

$EManCCNFunc = new EManCCNFunc;
$helper = new helper;

$oldDir = 'OLD/';
$errDir = 'ERROR/';

$getFLocation = 'D:/Messages/CCN/'; //JejuAir/


//======================FUNCTIONS===========================
function CountBOL($Total_number_of_mawb, $CountBOL)
{
    if ($Total_number_of_mawb <= $CountBOL) {
        return true;
    }
    return false;
}

function ReadXMLFileBOLCebuPacific($bol)
{
    $AWBXMLErr = array();
    $array = array();

    $arr = array();

    if (isset($bol["Identification_segment"]["Bol_reference"]) && !is_array($bol["Identification_segment"]["Bol_reference"])) {
        $AWBReference = '203' . $bol["Identification_segment"]["Bol_reference"];
        $arr["AWBReference"] = $AWBReference;
        /* echo $AWBReference;
        die(); */

    } else if (isset($bol["IDENTIFICATION_SEGMENT"]["BOL_REFERENCE"]) && !is_array($bol["IDENTIFICATION_SEGMENT"]["BOL_REFERENCE"])) {

        $AWBReference = '203' . $bol["IDENTIFICATION_SEGMENT"]["BOL_REFERENCE"];
    } else {
        array_push($AWBXMLErr, "AWBReference");
    }


    if (isset($bol["Identification_segment"]["Customs_office_segment"]["Code"]) && !is_array($bol["Identification_segment"]["Customs_office_segment"]["Code"])) {
        $BLCustoms_office_segment = $bol["Identification_segment"]["Customs_office_segment"]["Code"];
        $arr["Customs_office_segment"] = $BLCustoms_office_segment;
        //echo $BLCustoms_office_segment;

    } else if (isset($bol["IDENTIFICATION_SEGMENT"]["CUSTOMS_OFFICE_SEGMENT"]["CODE"]) && !is_array($bol["IDENTIFICATION_SEGMENT"]["CUSTOMS_OFFICE_SEGMENT"]["CODE"])) {

        $BLCustoms_office_segment = $bol["IDENTIFICATION_SEGMENT"]["CUSTOMS_OFFICE_SEGMENT"]["CODE"];
    } else {
        array_push($AWBXMLErr, "Customs_office_segment");
    }


    if (isset($bol["Bol_specific_segment"]["Line_number"]) && !is_array($bol["Bol_specific_segment"]["Line_number"])) {
        $Line_number = $bol["Bol_specific_segment"]["Line_number"];
        $arr["Line_number"] = $Line_number;
        //echo $Line_number;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["LINE_NUMBER"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["LINE_NUMBER"])) {

        $Line_number = $bol["BOL_SPECIFIC_SEGMENT"]["LINE_NUMBER"];
    } else {
        array_push($AWBXMLErr, "Line_number");
    }


    if (isset($bol["Bol_specific_segment"]["Bol_type_segment"]["Code"]) && !is_array($bol["Bol_specific_segment"]["Bol_type_segment"]["Code"])) {
        $AWBType = $bol["Bol_specific_segment"]["Bol_type_segment"]["Code"];
        $arr["AWBType"] = $AWBType;
        //echo $AWBType;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["BOL_TYPE_SEGMENT"]["CODE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["BOL_TYPE_SEGMENT"]["CODE"])) {

        $AWBType = $bol["BOL_SPECIFIC_SEGMENT"]["BOL_TYPE_SEGMENT"]["CODE"];
    } else {
        array_push($AWBXMLErr, "AWBType");
    }


    if (isset($bol["Bol_specific_segment"]["Bol_Nature"]) && !is_array($bol["Bol_specific_segment"]["Bol_Nature"])) {
        $AWB_Nature = $bol["Bol_specific_segment"]["Bol_Nature"];
        $arr["AWB_Nature"] = $AWB_Nature;
        //echo $AWB_Nature;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["BOL_NATURE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["BOL_NATURE"])) {

        $AWB_Nature = $bol["BOL_SPECIFIC_SEGMENT"]["BOL_NATURE"];
    } else {
        array_push($AWBXMLErr, "AWB_Nature");
    }


    if (isset($bol["Bol_specific_segment"]["Unique_carrier_reference"]) && !is_array($bol["Bol_specific_segment"]["Unique_carrier_reference"])) {
        $Unique_carrier_reference = $bol["Bol_specific_segment"]["Unique_carrier_reference"];
        $arr["Unique_carrier_reference"] = $Unique_carrier_reference;
        //echo $Unique_carrier_reference;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["UNIQUE_CARRIER_REFERENCE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["UNIQUE_CARRIER_REFERENCE"])) {

        $Unique_carrier_reference = $bol["BOL_SPECIFIC_SEGMENT"]["UNIQUE_CARRIER_REFERENCE"];
    } else {
        //array_push($AWBXMLErr, "Unique_carrier_reference");
        $Unique_carrier_reference = "";
        $arr["Unique_carrier_reference"] = $Unique_carrier_reference;
    }


    //====shipper

    if (isset($bol["Bol_specific_segment"]["Exporter_segment"]["Name"]) && !is_array($bol["Bol_specific_segment"]["Exporter_segment"]["Name"])) {
        $SName = $bol["Bol_specific_segment"]["Exporter_segment"]["Name"];
        //echo $SName;
        $arr["SName"] = $SName;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["EXPORT_SEGMENT"]["NAME"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["EXPORT_SEGMENT"]["NAME"])) {

        $SName = $bol["BOL_SPECIFIC_SEGMENT"]["EXPORT_SEGMENT"]["NAME"];
    } else {
        array_push($AWBXMLErr, "ShipperName");
    }


    if (isset($bol["Bol_specific_segment"]["Exporter_segment"]["Address"]) && !is_array($bol["Bol_specific_segment"]["Exporter_segment"]["Address"])) {
        $SAddress1 = $bol["Bol_specific_segment"]["Exporter_segment"]["Address"];
        $address = str_split($SAddress1, 35);

        $arr["SAddress1"] = isset($address[0]) ? preg_replace('/\s+/', ' ', trim($address[0])) : '';
        $arr["SAddress2"] = isset($address[1]) ? preg_replace('/\s+/', ' ', trim($address[1])) : '';
        $arr["SAddress3"] = isset($address[2]) ? preg_replace('/\s+/', ' ', trim($address[2])) : '';
        $arr["SAddress4"] = isset($address[3]) ? preg_replace('/\s+/', ' ', trim($address[3])) : '';


        //echo $SAddress1;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["EXPORT_SEGMENT"]["ADDRESS"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["EXPORT_SEGMENT"]["ADDRESS"])) {

        $SAddress1 = $bol["BOL_SPECIFIC_SEGMENT"]["EXPORT_SEGMENT"]["ADDRESS"];
        $address = str_split($SAddress1, 35);

        $arr["SAddress1"] = isset($address[0]) ? $address[0] : '';
        $arr["SAddress2"] = isset($address[1]) ? ltrim($address[1]) : '';
        $arr["SAddress3"] = isset($address[2]) ? $address[2] : '';
        $arr["SAddress4"] = isset($address[3]) ? $address[3] : '';
        //echo $SAddress1;

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $SAddress1 = "";
        $arr["SAddress1"] = $SAddress1;
    }


    // if (isset($bol["Shipper_segment"]["Address2"]) && !is_array($bol["Shipper_segment"]["Address2"])) {
    //     $SAddress2        = $bol["Shipper_segment"]["Address2"];
    //     $arr["SAddress2"] = $SAddress2;
    //     //echo $SAddress2;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $SAddress2        = "";
    //     $arr["SAddress2"] = $SAddress2;
    // }


    // if (isset($bol["Shipper_segment"]["Address3"]) && !is_array($bol["Shipper_segment"]["Address3"])) {
    //     $SAddress3        = $bol["Shipper_segment"]["Address3"];
    //     //echo $SAddress3;
    //     $arr["SAddress3"] = $SAddress3;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $SAddress3        = "";
    //     $arr["SAddress3"] = $SAddress3;
    // }


    // if (isset($bol["Shipper_segment"]["Address4"]) && !is_array($bol["Shipper_segment"]["Address4"])) {
    //     $SAddress4        = $bol["Shipper_segment"]["Address4"];
    //     $arr["SAddress4"] = $SAddress4;
    //     //echo $SAddress4;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $SAddress4        = "";
    //     $arr["SAddress4"] = $SAddress4;
    // }


    //====consignee

    if (isset($bol["Bol_specific_segment"]["Consignee_segment"]["Name"]) && !is_array($bol["Bol_specific_segment"]["Consignee_segment"]["Name"]) && strlen($bol["Bol_specific_segment"]["Consignee_segment"]["Name"]) <= 35) {
        $CName = $bol["Bol_specific_segment"]["Consignee_segment"]["Name"];
        //echo $CName;
        $arr["CName"] = $CName;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["CONSIGNEE_SEGMENT"]["NAME"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["CONSIGNEE_SEGMENT"]["NAME"])) {

        $CName = $bol["BOL_SPECIFIC_SEGMENT"]["CONSIGNEE_SEGMENT"]["NAME"];
    } else {
        array_push($AWBXMLErr, "ConsigneeName");
    }


    if (isset($bol["Bol_specific_segment"]["Consignee_segment"]["Address"]) && !is_array($bol["Bol_specific_segment"]["Consignee_segment"]["Address"])) {
        $CAddress1 = $bol["Bol_specific_segment"]["Consignee_segment"]["Address"];

        $caddress = str_split($CAddress1, 35);

        $arr["CAddress1"] = isset($caddress[0]) ? preg_replace('/\s+/', ' ', trim($caddress[0])) : '';
        $arr["CAddress2"] = isset($caddress[1]) ? preg_replace('/\s+/', ' ', trim($caddress[1])) : '';
        $arr["CAddress3"] = isset($caddress[2]) ? preg_replace('/\s+/', ' ', trim($caddress[2])) : '';
        $arr["CAddress4"] = isset($caddress[3]) ? preg_replace('/\s+/', ' ', trim($caddress[3])) : '';

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["CONSIGNEE_SEGMENT"]["ADDRESS"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["CONSIGNEE_SEGMENT"]["ADDRESS"])) {

        $CAddress1 = $bol["BOL_SPECIFIC_SEGMENT"]["CONSIGNEE_SEGMENT"]["ADDRESS"];

        $caddress = str_split($CAddress1, 35);

        $arr["CAddress1"] = isset($caddress[0]) ? $caddress[0] : '';
        $arr["CAddress2"] = isset($caddress[1]) ? $caddress[1] : '';
        $arr["CAddress3"] = isset($caddress[2]) ? $caddress[2] : '';
        $arr["CAddress4"] = isset($caddress[3]) ? $caddress[3] : '';
    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $CAddress1 = "";
        $arr["CAddress1"] = $CAddress1;
    }


    // if (isset($bol["Consignee_segment"]["Address2"]) && !is_array($bol["Consignee_segment"]["Address2"])) {
    //     $CAddress2        = $bol["Consignee_segment"]["Address2"];
    //     $arr["CAddress2"] = $CAddress2;
    //     //echo $CAddress2;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $CAddress2        = "";
    //     $arr["CAddress2"] = $CAddress2;
    // }


    // if (isset($bol["Consignee_segment"]["Address3"]) && !is_array($bol["Consignee_segment"]["Address3"])) {
    //     $CAddress3        = $bol["Consignee_segment"]["Address3"];
    //     //echo $CAddress3;
    //     $arr["CAddress3"] = $CAddress3;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $CAddress3        = "";
    //     $arr["CAddress3"] = $CAddress3;
    // }


    // if (isset($bol["Consignee_segment"]["Address4"]) && !is_array($bol["Consignee_segment"]["Address4"])) {
    //     $CAddress4        = $bol["Consignee_segment"]["Address4"];
    //     //echo $CAddress4;
    //     $arr["CAddress4"] = $CAddress4;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $CAddress4        = "";
    //     $arr["CAddress4"] = $CAddress4;
    // }


    //Notify

    if (isset($bol["Bol_specific_segment"]["Notify_segment"]["Name"]) && !is_array($bol["Bol_specific_segment"]["Notify_segment"]["Name"]) && strlen($bol["Bol_specific_segment"]["Notify_segment"]["Name"]) <= 35) {
        $NName = $bol["Bol_specific_segment"]["Notify_segment"]["Name"];
        $arr["NName"] = $NName;
        //echo $NName;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["NOTIFY_SEGMENT"]["NAME"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["NOTIFY_SEGMENT"]["NAME"])) {

        $NName = $bol["BOL_SPECIFIC_SEGMENT"]["NOTIFY_SEGMENT"]["NAME"];
    } else {
        array_push($AWBXMLErr, "NotifyName");
    }


    if (isset($bol["Bol_specific_segment"]["Notify_segment"]["Address"]) && !is_array($bol["Bol_specific_segment"]["Notify_segment"]["Address"])) {
        $NAddress1 = $bol["Bol_specific_segment"]["Notify_segment"]["Address"];

        $Naddress = str_split($NAddress1, 35);

        $arr["NAddress1"] = isset($Naddress[0]) ? preg_replace('/\s+/', ' ', trim($Naddress[0])) : '';
        $arr["NAddress2"] = isset($Naddress[1]) ? preg_replace('/\s+/', ' ', trim($Naddress[1])) : '';
        $arr["NAddress3"] = isset($Naddress[2]) ? preg_replace('/\s+/', ' ', trim($Naddress[2])) : '';
        $arr["NAddress4"] = isset($Naddress[3]) ? preg_replace('/\s+/', ' ', trim($Naddress[3])) : '';

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["NOTIFY_SEGMENT"]["ADDRESS"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["NOTIFY_SEGMENT"]["ADDRESS"])) {
        $NAddress1 = $bol["BOL_SPECIFIC_SEGMENT"]["NOTIFY_SEGMENT"]["ADDRESS"];

        $Naddress = str_split($NAddress1, 35);

        $arr["NAddress1"] = isset($Naddress[0]) ? $Naddress[0] : '';
        $arr["NAddress2"] = isset($Naddress[1]) ? $Naddress[1] : '';
        $arr["NAddress3"] = isset($Naddress[2]) ? $Naddress[2] : '';
        $arr["NAddress4"] = isset($Naddress[3]) ? $Naddress[3] : '';

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $NAddress1 = "";
        $arr["NAddress1"] = $NAddress1;
    }

    // array_push($array, $arr, $AWBXMLErr);

    // return $array;
    // if (isset($bol["Notify_segment"]["Address2"]) && !is_array($bol["Notify_segment"]["Address2"])) {
    //     $NAddress2        = $bol["Notify_segment"]["Address2"];
    //     //echo $NAddress2;
    //     $arr["NAddress2"] = $NAddress2;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $NAddress2        = "";
    //     $arr["NAddress2"] = $NAddress2;
    // }


    // if (isset($bol["Notify_segment"]["Address3"]) && !is_array($bol["Notify_segment"]["Address3"])) {
    //     $NAddress3        = $bol["Notify_segment"]["Address3"];
    //     $arr["NAddress3"] = $NAddress3;
    //     //echo $NAddress3;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $NAddress3        = "";
    //     $arr["NAddress3"] = $NAddress3;
    // }


    // if (isset($bol["Notify_segment"]["Address4"]) && !is_array($bol["Notify_segment"]["Address4"])) {
    //     $NAddress4        = $bol["Notify_segment"]["Address4"];
    //     //echo $NAddress4;
    //     $arr["NAddress4"] = $NAddress4;

    // } else {
    //     //array_push($AWBXMLErr, "ShipperName");
    //     $NAddress4        = "";
    //     $arr["NAddress4"] = $NAddress4;
    // }


    if (isset($bol["Bol_specific_segment"]["Place_of_loading_segment"]["Code"]) && !is_array($bol["Bol_specific_segment"]["Place_of_loading_segment"]["Code"])) {
        $Place_of_loading_segment = $bol["Bol_specific_segment"]["Place_of_loading_segment"]["Code"];
        $arr["Place_of_loading_segment"] = $Place_of_loading_segment;
        //echo $Place_of_loading_segment;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["PLACE_OF_LOADING_SEGMENT"]["CODE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["PLACE_OF_LOADING_SEGMENT"]["CODE"])) {
        $Place_of_loading_segment = $bol["BOL_SPECIFIC_SEGMENT"]["PLACE_OF_LOADING_SEGMENT"]["CODE"];

    } else {
        array_push($AWBXMLErr, "Place_of_loading_segment");
    }


    if (isset($bol["Bol_specific_segment"]["Place_of_unloading_segment"]["Code"]) && !is_array($bol["Bol_specific_segment"]["Place_of_unloading_segment"]["Code"])) {
        $Place_of_unloading_segment = $bol["Bol_specific_segment"]["Place_of_unloading_segment"]["Code"];
        $arr["Place_of_unloading_segment"] = $Place_of_unloading_segment;
        //echo $Place_of_unloading_segment;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["PLACE_OF_UNLOADING_SEGMENT"]["CODE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["PLACE_OF_UNLOADING_SEGMENT"]["CODE"])) {
        $Place_of_unloading_segment = $bol["BOL_SPECIFIC_SEGMENT"]["PLACE_OF_UNLOADING_SEGMENT"]["CODE"];
        $arr["Place_of_unloading_segment"] = $Place_of_unloading_segment;
        //echo $Place_of_unloading_segment;

    } else {
        array_push($AWBXMLErr, "Place_of_unloading_segment");
    }


    if (isset($bol["Bol_specific_segment"]["Packages_segment"]["Package_type_code"]) && !is_array($bol["Bol_specific_segment"]["Packages_segment"]["Package_type_code"])) {
        $Package_type_code = $bol["Bol_specific_segment"]["Packages_segment"]["Package_type_code"];
        $arr["Package_type_code"] = $Package_type_code;
        //echo $Package_type_code;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["PACKAGES_SEGMENT"]["PACKAGE_TYPE_CODE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["PACKAGES_SEGMENT"]["PACKAGE_TYPE_CODE"])) {
        $Package_type_code = $bol["BOL_SPECIFIC_SEGMENT"]["PACKAGES_SEGMENT"]["PACKAGE_TYPE_CODE"];
        $arr["Package_type_code"] = $Package_type_code;
        //echo $Package_type_code;

    } else {
        array_push($AWBXMLErr, "Package_type_code");
    }

    if (isset($bol["Bol_specific_segment"]["Packages_segment"]["Number_of_packages"]) && !is_array($bol["Bol_specific_segment"]["Packages_segment"]["Number_of_packages"])) {
        $Number_of_packages = $bol["Bol_specific_segment"]["Packages_segment"]["Number_of_packages"];
        $arr["Number_of_packages"] = $Number_of_packages;
        //echo $Number_of_packages;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["PACKAGES_SEGMENT"]["NUMBER_OF_PACKAGES"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["PACKAGES_SEGMENT"]["NUMBER_OF_PACKAGES"])) {
        $Number_of_packages = $bol["BOL_SPECIFIC_SEGMENT"]["PACKAGES_SEGMENT"]["NUMBER_OF_PACKAGES"];
        $arr["Number_of_packages"] = $Number_of_packages;
        //echo $Number_of_packages;

    } else {
        array_push($AWBXMLErr, "Number_of_packages");
    }


    if (isset($bol["Bol_specific_segment"]["Total_gross_mass_manifested"]) && !is_array($bol["Bol_specific_segment"]["Total_gross_mass_manifested"])) {
        $Total_gross_mass_manifested = $bol["Bol_specific_segment"]["Total_gross_mass_manifested"];
        $arr["Total_gross_mass_manifested"] = $Total_gross_mass_manifested;
        //echo $Total_gross_mass_manifested;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["TOTAL_GROSS_MASS_MANIFESTED"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["TOTAL_GROSS_MASS_MANIFESTED"])) {
        $Total_gross_mass_manifested = $bol["BOL_SPECIFIC_SEGMENT"]["TOTAL_GROSS_MASS_MANIFESTED"];
        $arr["Total_gross_mass_manifested"] = $Total_gross_mass_manifested;
        //echo $Total_gross_mass_manifested;

    } else {
        array_push($AWBXMLErr, "Total_gross_mass_manifested");
    }

    if (isset($bol["Bol_specific_segment"]["Volume_in_cubic_meters"]) && !is_array($bol["Bol_specific_segment"]["Volume_in_cubic_meters"])) {
        $Volume_in_cubic_meters = $bol["Bol_specific_segment"]["Volume_in_cubic_meters"];
        $arr["Volume_in_cubic_meters"] = $Volume_in_cubic_meters;
        //echo $Volume_in_cubic_meters;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["VOLUME_IN_CUBIC_METERS"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["VOLUME_IN_CUBIC_METERS"])) {
        $Volume_in_cubic_meters = $bol["BOL_SPECIFIC_SEGMENT"]["VOLUME_IN_CUBIC_METERS"];
        $arr["Volume_in_cubic_meters"] = $Volume_in_cubic_meters;
        //echo $Volume_in_cubic_meters;

    } else {
        array_push($AWBXMLErr, "Volume_in_cubic_meters");
    }

    $excess = '';

    if (isset($bol["Bol_specific_segment"]["Goods_segment"]["Goods_description"]) && !is_array($bol["Bol_specific_segment"]["Goods_segment"]["Goods_description"])) {
        $Goods1 = $bol["Bol_specific_segment"]["Goods_segment"]["Goods_description"];

        if (strlen($Goods1) > 175) {
            $excess = substr($Goods1, 175, strlen($Goods1));
            $Goods1 = substr($Goods1, 0, 175);
        }

        $arr["Goods1"] = $Goods1;
        //echo $Goods1;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["GOODS_SEGMENT"]["GOODS_DESCRIPTION"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["GOODS_SEGMENT"]["GOODS_DESCRIPTION"])) {
        $Goods1 = $bol["BOL_SPECIFIC_SEGMENT"]["GOODS_SEGMENT"]["GOODS_DESCRIPTION"];

        if (strlen($Goods1) > 175) {
            $excess = substr($Goods1, 175, strlen($Goods1));
            $Goods1 = substr($Goods1, 0, 175);
        }

        $arr["Goods1"] = $Goods1;
        //echo $Goods1;

    } else {
        array_push($AWBXMLErr, "Goods1");
    }

    if (isset($bol["Bol_specific_segment"]["Shipping_segment"]["Shipping_marks"]) && !is_array($bol["Bol_specific_segment"]["Shipping_segment"]["Shipping_marks"])) {
        $Marking1 = $bol["Bol_specific_segment"]["Shipping_segment"]["Shipping_marks"];

        if (strlen($Marking1) < 175) {
            $add = 175 - (strlen($Marking1) + 1);
            $Marking1 = $Marking1 . ' ' . substr($excess, 0, $add);
        }

        $arr["Marking1"] = $Marking1;
        //echo $Marking1;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["SHIPPING_SEGMENT"]["SHIPPING_MARKS"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["SHIPPING_SEGMENT"]["SHIPPING_MARKS"])) {
        $Marking1 = $bol["BOL_SPECIFIC_SEGMENT"]["SHIPPING_SEGMENT"]["SHIPPING_MARKS"];

        if (strlen($Marking1) < 175) {
            $add = 175 - (strlen($Marking1) + 1);
            $Marking1 = $Marking1 . ' ' . substr($excess, 0, $add - 1);
        }

        $arr["Marking1"] = $Marking1;
        //echo $Marking1;

    } else {
        array_push($AWBXMLErr, "Marking1");
    }

    if (isset($bol["Bol_specific_segment"]["Freight_segment"]["Value"]) && !is_array($bol["Bol_specific_segment"]["Freight_segment"]["Value"])) {
        $FreightAmount = $bol["Bol_specific_segment"]["Freight_segment"]["Value"];

        if ($FreightAmount == 0.01) {
            $FreightAmount = 1;
        }

        $arr["FreightAmount"] = $FreightAmount;
        //echo $FreightAmount;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["FREIGHT_SEGMENT"]["VALUE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["FREIGHT_SEGMENT"]["VALUE"])) {
        $FreightAmount = $bol["BOL_SPECIFIC_SEGMENT"]["FREIGHT_SEGMENT"]["VALUE"];

        if ($FreightAmount == 0.01) {
            $FreightAmount = 1;
        }

        $arr["FreightAmount"] = $FreightAmount;
        //echo $FreightAmount;

    } else {
        array_push($AWBXMLErr, "FreightAmount");
    }

    if (isset($bol["Bol_specific_segment"]["Insurance_segment"]["Value"]) && !is_array($bol["Bol_specific_segment"]["Insurance_segment"]["Value"])) {
        $InsuranceAmount = $bol["Bol_specific_segment"]["Insurance_segment"]["Value"];

        if ($InsuranceAmount == 0.01) {
            $InsuranceAmount = 1;
        }

        $arr["InsuranceAmount"] = $InsuranceAmount;
        //echo $InsuranceAmount;

    } else if (isset($bol["BOL_SPECIFIC_SEGMENT"]["INSURANCE_SEGMENT"]["VALUE"]) && !is_array($bol["BOL_SPECIFIC_SEGMENT"]["INSURANCE_SEGMENT"]["VALUE"])) {
        $InsuranceAmount = $bol["BOL_SPECIFIC_SEGMENT"]["Insurance_sINSURANCE_SEGMENTegment"]["VALUE"];

        if ($InsuranceAmount == 0.01) {
            $InsuranceAmount = 1;
        }

        $arr["InsuranceAmount"] = $InsuranceAmount;
        //echo $InsuranceAmount;

    } else {
        array_push($AWBXMLErr, "InsuranceAmount");
    }

    //print_r($arr);
    //die();

    array_push($array, $arr, $AWBXMLErr);

    return $array;

}

function ReadXMLFileBOL($bol)
{
    $AWBXMLErr = array();
    $array = array();

    $arr = array();

    if (isset($bol["AWBReference"]) && !is_array($bol["AWBReference"])) {
        $AWBReference = $bol["AWBReference"];
        $arr["AWBReference"] = $AWBReference;
        //echo $AWBReference;
        //die();

    } else {
        array_push($AWBXMLErr, "AWBReference");
    }

    if (isset($bol["Customs_office_segment"]) && !is_array($bol["Customs_office_segment"])) {
        $BLCustoms_office_segment = $bol["Customs_office_segment"];
        $arr["Customs_office_segment"] = $BLCustoms_office_segment;
        //echo $BLCustoms_office_segment;

    } else {
        array_push($AWBXMLErr, "Customs_office_segment");
    }


    if (isset($bol["Line_number"]) && !is_array($bol["Line_number"])) {
        $Line_number = $bol["Line_number"];
        $arr["Line_number"] = $Line_number;
        //echo $Line_number;

    } else {
        array_push($AWBXMLErr, "Line_number");
    }


    if (isset($bol["AWBType"]) && !is_array($bol["AWBType"])) {
        $AWBType = $bol["AWBType"];
        $arr["AWBType"] = $AWBType;
        //echo $AWBType;

    } else {
        array_push($AWBXMLErr, "AWBType");
    }


    if (isset($bol["AWB_Nature"]) && !is_array($bol["AWB_Nature"])) {
        $AWB_Nature = $bol["AWB_Nature"];
        $arr["AWB_Nature"] = $AWB_Nature;
        //echo $AWB_Nature;

    } else {
        array_push($AWBXMLErr, "AWB_Nature");
    }


    if (isset($bol["Unique_carrier_reference"]) && !is_array($bol["Unique_carrier_reference"])) {
        $Unique_carrier_reference = $bol["Unique_carrier_reference"];
        $arr["Unique_carrier_reference"] = $Unique_carrier_reference;
        //echo $Unique_carrier_reference;

    } else {
        //array_push($AWBXMLErr, "Unique_carrier_reference");
        $Unique_carrier_reference = "";
        $arr["Unique_carrier_reference"] = $Unique_carrier_reference;
    }


    //====shipper

    if (isset($bol["Shipper_segment"]["SName"]) && !is_array($bol["Shipper_segment"]["SName"])) {
        $SName = $bol["Shipper_segment"]["SName"];
        //echo $SName;
//        $arr["SName"] = $SName;
        $arr["SName"] = substr($SName, 0, 35);

    } else {
        array_push($AWBXMLErr, "ShipperName");
    }


    if (isset($bol["Shipper_segment"]["Address1"]) && !is_array($bol["Shipper_segment"]["Address1"])) {
        $SAddress1 = $bol["Shipper_segment"]["Address1"];
//        $arr["SAddress1"] = $SAddress1;
        //echo $SAddress1;
        $arr["SAddress1"] = substr($SAddress1, 0, 35);
    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $SAddress1 = "";
        $arr["SAddress1"] = $SAddress1;
    }


    if (isset($bol["Shipper_segment"]["Address2"]) && !is_array($bol["Shipper_segment"]["Address2"])) {
        $SAddress2 = $bol["Shipper_segment"]["Address2"];
//        $arr["SAddress2"] = $SAddress2;
        //echo $SAddress2;
        $arr["SAddress2"] = substr($SAddress2, 0, 35);


    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $SAddress2 = "";
        $arr["SAddress2"] = $SAddress2;
    }


    if (isset($bol["Shipper_segment"]["Address3"]) && !is_array($bol["Shipper_segment"]["Address3"])) {
        $SAddress3 = $bol["Shipper_segment"]["Address3"];
        //echo $SAddress3;
//        $arr["SAddress3"] = $SAddress3;
        $arr["SAddress3"] = substr($SAddress3, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $SAddress3 = "";
        $arr["SAddress3"] = $SAddress3;
    }


    if (isset($bol["Shipper_segment"]["Address4"]) && !is_array($bol["Shipper_segment"]["Address4"])) {
        $SAddress4 = $bol["Shipper_segment"]["Address4"];
//        $arr["SAddress4"] = $SAddress4;
        //echo $SAddress4;
        $arr["SAddress4"] = substr($SAddress4, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $SAddress4 = "";
        $arr["SAddress4"] = $SAddress4;
    }


    //====consignee

    if (isset($bol["Consignee_segment"]["CName"]) && !is_array($bol["Consignee_segment"]["CName"])) {
        $CName = $bol["Consignee_segment"]["CName"];
        //echo $CName;
//        $arr["CName"] = $CName;
        $arr["CName"] = substr($CName, 0, 35);


    } else {
        array_push($AWBXMLErr, "ConsigneeName");
    }


    if (isset($bol["Consignee_segment"]["Address1"]) && !is_array($bol["Consignee_segment"]["Address1"])) {
        $CAddress1 = $bol["Consignee_segment"]["Address1"];
//        $arr["CAddress1"] = $CAddress1;
        //echo $CAddress1;
        $arr["CAddress1"] = substr($CAddress1, 0, 35);


    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $CAddress1 = "";
        $arr["CAddress1"] = $CAddress1;
    }


    if (isset($bol["Consignee_segment"]["Address2"]) && !is_array($bol["Consignee_segment"]["Address2"])) {
        $CAddress2 = $bol["Consignee_segment"]["Address2"];
//        $arr["CAddress2"] = $CAddress2;
        //echo $CAddress2;
        $arr["CAddress2"] = substr($CAddress2, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $CAddress2 = "";
        $arr["CAddress2"] = $CAddress2;
    }


    if (isset($bol["Consignee_segment"]["Address3"]) && !is_array($bol["Consignee_segment"]["Address3"])) {
        $CAddress3 = $bol["Consignee_segment"]["Address3"];
        //echo $CAddress3;
//        $arr["CAddress3"] = $CAddress3;
        $arr["CAddress3"] = substr($CAddress3, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $CAddress3 = "";
        $arr["CAddress3"] = $CAddress3;
    }


    if (isset($bol["Consignee_segment"]["Address4"]) && !is_array($bol["Consignee_segment"]["Address4"])) {
        $CAddress4 = $bol["Consignee_segment"]["Address4"];
        //echo $CAddress4;
//        $arr["CAddress4"] = $CAddress4;
        $arr["CAddress4"] = substr($CAddress4, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $CAddress4 = "";
        $arr["CAddress4"] = $CAddress4;
    }


    //Notify

    if (isset($bol["Notify_segment"]["Name"]) && !is_array($bol["Notify_segment"]["Name"])) {
        $NName = $bol["Notify_segment"]["Name"];
//        $arr["NName"] = $NName;
        //echo $NName;
        $arr["NName"] = substr($NName, 0, 35);

    } else {
        array_push($AWBXMLErr, "NotifyName");
    }


    if (isset($bol["Notify_segment"]["Address1"]) && !is_array($bol["Notify_segment"]["Address1"])) {
        $NAddress1 = $bol["Notify_segment"]["Address1"];
        //echo $NAddress1;
//        $arr["NAddress1"] = $NAddress1;
        $arr["NAddress1"] = substr($NAddress1, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $NAddress1 = "";
        $arr["NAddress1"] = $NAddress1;
    }


    if (isset($bol["Notify_segment"]["Address2"]) && !is_array($bol["Notify_segment"]["Address2"])) {
        $NAddress2 = $bol["Notify_segment"]["Address2"];
        //echo $NAddress2;
        $arr["NAddress2"] = $NAddress2;
        $arr["NAddress2"] = substr($NAddress2, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $NAddress2 = "";
        $arr["NAddress2"] = $NAddress2;
    }


    if (isset($bol["Notify_segment"]["Address3"]) && !is_array($bol["Notify_segment"]["Address3"])) {
        $NAddress3 = $bol["Notify_segment"]["Address3"];
//        $arr["NAddress3"] = $NAddress3;
        //echo $NAddress3;
        $arr["NAddress3"] = substr($NAddress3, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $NAddress3 = "";
        $arr["NAddress3"] = $NAddress3;
    }


    if (isset($bol["Notify_segment"]["Address4"]) && !is_array($bol["Notify_segment"]["Address4"])) {
        $NAddress4 = $bol["Notify_segment"]["Address4"];
        //echo $NAddress4;
//        $arr["NAddress4"] = $NAddress4;
        $arr["NAddress4"] = substr($NAddress4, 0, 35);

    } else {
        //array_push($AWBXMLErr, "ShipperName");
        $NAddress4 = "";
        $arr["NAddress4"] = $NAddress4;
    }


    if (isset($bol["Place_of_loading_segment"]) && !is_array($bol["Place_of_loading_segment"])) {
        $Place_of_loading_segment = $bol["Place_of_loading_segment"];
        $arr["Place_of_loading_segment"] = $Place_of_loading_segment;
        //echo $Place_of_loading_segment;

    } else {
        array_push($AWBXMLErr, "Place_of_loading_segment");
    }


    if (isset($bol["Place_of_unloading_segment"]) && !is_array($bol["Place_of_unloading_segment"])) {
        $Place_of_unloading_segment = $bol["Place_of_unloading_segment"];
        $arr["Place_of_unloading_segment"] = $Place_of_unloading_segment;
        //echo $Place_of_unloading_segment;

    } else {
        array_push($AWBXMLErr, "Place_of_unloading_segment");
    }


    if (isset($bol["Freight_Info"]["Package_type_code"]) && !is_array($bol["Freight_Info"]["Package_type_code"])) {
        $Package_type_code = $bol["Freight_Info"]["Package_type_code"];
        $arr["Package_type_code"] = $Package_type_code;
        //echo $Package_type_code;

    } else {
        array_push($AWBXMLErr, "Package_type_code");
    }

    if (isset($bol["Freight_Info"]["Number_of_packages"]) && !is_array($bol["Freight_Info"]["Number_of_packages"])) {
        $Number_of_packages = $bol["Freight_Info"]["Number_of_packages"];
        $arr["Number_of_packages"] = $Number_of_packages;
        //echo $Number_of_packages;

    } else {
        array_push($AWBXMLErr, "Number_of_packages");
    }


    if (isset($bol["Freight_Info"]["Total_gross_mass_manifested"]) && !is_array($bol["Freight_Info"]["Total_gross_mass_manifested"])) {
        $Total_gross_mass_manifested = $bol["Freight_Info"]["Total_gross_mass_manifested"];
        $arr["Total_gross_mass_manifested"] = $Total_gross_mass_manifested;
        //echo $Total_gross_mass_manifested;

    } else {
        array_push($AWBXMLErr, "Total_gross_mass_manifested");
    }

    if (isset($bol["Freight_Info"]["Volume_in_cubic_meters"]) && !is_array($bol["Freight_Info"]["Volume_in_cubic_meters"])) {
        $Volume_in_cubic_meters = $bol["Freight_Info"]["Volume_in_cubic_meters"];
        $arr["Volume_in_cubic_meters"] = $Volume_in_cubic_meters;
        //echo $Volume_in_cubic_meters;

    } else {
        array_push($AWBXMLErr, "Volume_in_cubic_meters");
    }

    $excess = '';

    if (isset($bol["Freight_Info"]["Goods1"]) && !is_array($bol["Freight_Info"]["Goods1"])) {
        $Goods1 = $bol["Freight_Info"]["Goods1"];

        if (strlen($Goods1) > 175) {
            $excess = substr($Goods1, 175, strlen($Goods1));
            $Goods1 = substr($Goods1, 0, 175);
        }

        $arr["Goods1"] = $Goods1;
        //echo $Goods1;

    } else {
        array_push($AWBXMLErr, "Goods1");
    }

    if (isset($bol["Freight_Info"]["Marking1"]) && !is_array($bol["Freight_Info"]["Marking1"])) {
        $Marking1 = $bol["Freight_Info"]["Marking1"];

        if (strlen($Marking1) < 175) {
            $add = 175 - (strlen($Marking1) + 1);
            $Marking1 = $Marking1 . ' ' . substr($excess, 0, $add - 1);
        }

        $arr["Marking1"] = $Marking1;
        //echo $Marking1;

    } else {
        array_push($AWBXMLErr, "Marking1");
    }

    if (isset($bol["FreightValue"]["FreightAmount"]) && !is_array($bol["FreightValue"]["FreightAmount"])) {
        $FreightAmount = $bol["FreightValue"]["FreightAmount"];

        if ($FreightAmount == 0.01) {
            $FreightAmount = 1;
        }

        $arr["FreightAmount"] = $FreightAmount;
        //echo $FreightAmount;

    } else {
        array_push($AWBXMLErr, "FreightAmount");
    }

    if (isset($bol["FreightValue"]["InsuranceAmount"]) && !is_array($bol["FreightValue"]["InsuranceAmount"])) {
        $InsuranceAmount = $bol["FreightValue"]["InsuranceAmount"];

        if ($InsuranceAmount == 0.01) {
            $InsuranceAmount = 1;
        }

        $arr["InsuranceAmount"] = $InsuranceAmount;
        //echo $InsuranceAmount;

    } else {
        array_push($AWBXMLErr, "InsuranceAmount");
    }

    //print_r($arr);
    //die();

    array_push($array, $arr, $AWBXMLErr);

    return $array;

}

//-----------------ERROR FUNC---------------------------
//-----MANIFEST GEN----------
function sendErrorNotificationXMLGEN($EManCCNFunc, $file, $emailadd, $RegNo, $XMLErr, $Customs_office_segment)
{

    $recepientName = 'INS';

    $subjectRef = $RegNo;

    if ($RegNo == '' || $RegNo == null) {
        $subjectRef = $file;
    }

    $subject = "eMANIFEST ALERT: Auto Processing of " . $subjectRef;

    $htmlMessage = '<p>The system has just processed your file <i>' . $file . '</i> but encountered an ERROR see below for the details.<br />';

    if (count($XMLErr) > 0) {

        // $htmlMessage .= '<br />MANIFEST XML ERROR<br /><br />';
        $htmlMessage .= '<br />';
        $htmlMessage .= '<br />';
        $htmlMessage .= 'File Read: <b>MANIFEST</b>';
        $htmlMessage .= '<br />';
        $htmlMessage .= 'Port No: <b>' . $Customs_office_segment . '</b>';
        $htmlMessage .= '<br />';
        $htmlMessage .= 'Status: <b>ERROR</b>';
        $htmlMessage .= '<br />';
        $htmlMessage .= 'Error: <b>XML - Missing Information</b>';
        $htmlMessage .= '<br />';

        $ctr = 1;
        foreach ($XMLErr as $err) {
            $htmlMessage .= $ctr . '. ' . $err;
            $htmlMessage .= '<br />';
            $ctr++;
        }


    }

    $htmlMessage .= " <br /><br />
                            <!--Login to <a href='http://manifest.intercommerce.com.ph/'>eManifest web site</a>, to view the details, complete the information and to submit the application to BOC for processing.<br />
                             <br />-->
                            Note:<br />
                            For further assistance, please call 02-7521188 or email us at helpdesk@intercommerce.com.ph.<br />
                             <br />
                            Thank you.<br />
                            InterCommerce Network Services, Inc.<br />
                            (DO NOT REPLY. This is an auto-generated email)</p>";


    //die($htmlMessage);


    $recepientEmail = $emailadd;//'nkoriel@intercommerce.com.ph'; //
    $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'nkoriel@intercommerce.com.ph', 'hgfajutag@intercommerce.com.ph');
    $BCC = array('asantos@intercommerce.com.ph');

    if ($EManCCNFunc->SendEmailNotification($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage)) {
        return true;
    }
    return false;

}

function ErrorLogXMLGEN($RegNo, $XMLErr)
{
    $htmlMessage = '';
    if (count($XMLErr) > 0) {

        $htmlMessage .= 'File Read: MANIFEST';
        $htmlMessage .= "\n";
        $htmlMessage .= 'Status: ERROR';
        $htmlMessage .= "\n";
        $htmlMessage .= 'Error: XML - Missing Information';
        $htmlMessage .= "\n";

        $ctr = 1;
        foreach ($XMLErr as $err) {
            $htmlMessage .= $ctr . '. ' . $err;
            $htmlMessage .= "\n";
            $ctr++;
        }


    }
    return $htmlMessage;
}

function MoveFileXMLGEN($helper, $currentDirectory, $file, $errDir, $newDIR, $NewfileName, $txt)
{
    //for ERROR FOLDER
    if (!$helper->check_file_exists($currentDirectory . $errDir)) {

        $helper->create_dir($currentDirectory . $errDir);

    }

    //INSIDE ERROR FOLDER
    if (!$helper->check_file_exists($currentDirectory . $errDir . $newDIR)) {

        $helper->create_dir($currentDirectory . $errDir . $newDIR);

    }

    //NOW MOVE IT TO ERROR FOLDER


    $helper->move_file($currentDirectory . $file, $currentDirectory . $errDir . $newDIR . "/" . $NewfileName);

    //echo "\n\n".'ERROR at file: '.$file."\n\n";

    //NOW write the error log

    $myfile = fopen($currentDirectory . $errDir . $newDIR . "/" . $NewfileName . "--ERROR" . ".txt", "w") or die("Unable to open file!");
    fwrite($myfile, $txt);
    fclose($myfile);

    return true;

}

//------------END MANIFEST GEN-----------------------------

//------------MANIFEST BOL ---------------------------------


//-------------------END MANIFEST BOL--------------------------------
//-----------------END ERROR FUNC-----------------------------------

//------------------------SUCCESS FUNCTION--------------------------
function SendSuccessNotficationGen($EManCCNFunc, $file, $emailadd, $RegNo, $ApplNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival, $Total_number_of_mawb, $BOLStatus, $BOLErr, $ManifestStatus, $ManAdditionalErr, $FlightNo)
{
    $recepientName = 'INS';

    $errmsg = "";

    if ($ManAdditionalErr == 1) {
        $errmsg = " but encountered an ERROR see below for the details";

    }

    if (strlen($RegNo) != 0) {

        $subject = "eMANIFEST ALERT: Auto Processing of " . $RegNo;

    } else {

        $subject = "eMANIFEST ALERT: Auto Processing of " . $FlightNo . ' - ' . $Date_of_arrival . ' - ' . $ApplNo;

    }

    $htmlMessage = '<p>The system has just processed your file <i>' . $file . '</i>' . $errmsg . '.';
    $htmlMessage .= '<br />';

    $htmlMessage .= '<br />';
    $htmlMessage .= 'File Read: <b>MANIFEST</b>';
    $htmlMessage .= '<br />';

    if ($ManifestStatus == "SUCCESS") {
        $htmlMessage .= 'Status: <b>SUCCESS</b>';
    } else {
        $htmlMessage .= 'Status: <b>ERROR</b>';
        $htmlMessage .= '<br />';
        $htmlMessage .= 'Error: <b>' . $ManifestStatus . '</b>';
    }

    $htmlMessage .= '<br />';

    $htmlMessage .= '<br />';
    $htmlMessage .= 'Application No: ' . $ApplNo;
    $htmlMessage .= '<br />';
    $htmlMessage .= 'Registry Number: ' . $RegNo;
    $htmlMessage .= '<br />';
    $htmlMessage .= 'Port: ' . $Customs_office_segment;
    $htmlMessage .= '<br />';
    $htmlMessage .= 'Arrival Date: ' . $Date_of_arrival;
    $htmlMessage .= '<br />';
    $htmlMessage .= 'Arrival Time: ' . $Time_of_arrival;
    $htmlMessage .= '<br />';
    $htmlMessage .= 'Total BOL: ' . $Total_number_of_mawb;
    $htmlMessage .= '<br />';
    $htmlMessage .= '<br />';


    if (count($BOLStatus) > 0) {
        $htmlMessage .= '<br />';
        $htmlMessage .= 'File Read: <b>BOL</b>';
        $htmlMessage .= '<br />';
        foreach ($BOLStatus as $bol) {

            if (count($bol) == 4) {
                //WITH MISSING FIELD AT BOL

                if ($bol[0] == '' && $bol[0] == NULL) {
                    $htmlMessage .= '<br />';
                    $htmlMessage .= "No Specified BL Number";
                } else {
                    $htmlMessage .= '<br />';
                    $htmlMessage .= "BL Number: " . $bol[0];

                }

                $htmlMessage .= '<br />';
                $htmlMessage .= "Goods Description: " . $bol[3];
                $htmlMessage .= '<br />';
                $htmlMessage .= 'Status: <b>ERROR</b>';
                $htmlMessage .= '<br />';
                $htmlMessage .= 'Error: <b>' . $bol[1] . '</b>';
                $htmlMessage .= '<br />';

                $errFields = $bol[2];

                if (count($errFields) > 0) {
                    $ctr = 1;
                    foreach ($errFields as $field) {
                        $htmlMessage .= $ctr . '. ' . $field;
                        $htmlMessage .= '<br />';
                        $ctr++;
                    }
                }


            } else {
                $importer_name = isset($bol[4]) ? $bol[4] : '';
                $bl_number = isset($bol[0]) ? $bol[0] : '';
                $bl_nature_code = isset($bol[3]) ? $bol[3] : '';

                //FOR NO MISSING FIELD AT BOL
                $htmlMessage .= '<br />';
                $htmlMessage .= 'Importer Name: ' . $importer_name;
                $htmlMessage .= '<br />';
                $htmlMessage .= "BL Number: " . $bl_number;
                $htmlMessage .= '<br />';
                // $htmlMessage .= 'BL Nature Code: ' . $bol[3];
                if ($bl_nature_code == '28') {

                    $htmlMessage .= 'BL Nature Code: <b style="color:red; font-size:14px;">' . $bl_nature_code . '</b>';

                } else {

                    $htmlMessage .= 'BL Nature Code:' . $bl_nature_code;

                }
                $htmlMessage .= '<br />';
                $htmlMessage .= "Goods Description: " . $bol[2];
                $htmlMessage .= '<br />';
                if (isset($bol[1]) && $bol[1] == "SUCCESS") {
                    $htmlMessage .= 'Status: <b style="color:blue;">SUCCESS</b>';
                } elseif (isset($bol[1]) && $bol[1] == "Duplicate Entry") {
                    $htmlMessage .= 'Status: <b>ERROR</b>';
                    $htmlMessage .= '<br />';
                    $htmlMessage .= 'Error: <b>' . $bol[1] . '</b>';
                }
                $htmlMessage .= '<br />';
            }


        }

    }

    $htmlMessage .= '<br />';

    if (count($BOLErr) > 0) {

        $htmlMessage .= "<br /><br /><b>OTHER ERROR(S) FOUND</b><br />";

        foreach ($BOLErr as $err) {
            $htmlMessage .= "<br />" . $err . "<br />";
        }

    }

    $htmlMessage .= " <br /><br />
                            Login to <a href='http://manifest.intercommerce.com.ph/'>eManifest web site</a> to view the details.<br />
                             <br />
                            Note:<br />
                            For further assistance, please call 02-7521188 / 845-0509 or email us at helpdesk@intercommerce.com.ph.<br />
                             <br />
                            Thank you.<br />
                            InterCommerce Network Services, Inc.<br />
                            (DO NOT REPLY. This is an auto-generated email)</p>";


    //die($htmlMessage);

    $recepientEmail = $emailadd;
    //Email Editted by Hannah

//    $prefix = substr($RegNo, 0, 3);
//
//    if ($prefix === 'RHA' || $prefix === 'DUM') {
//        $recepientEmail = 'rhmnlops@tam.group'; // replace with actual email
//    }

    if ($recepientEmail == 'jerielmallari@tam.group') {
        // $CC = array('jaysonandres.mnl@asiagsa.com', 'helpdesk@intercommerce.com.ph', 'mandiaz.mnl@asiagsa.com', 'jonathanmartillana.mnl@asiagsa.com', 'white_loh@ccn.com.sg', 'customssupport@ccn.com.sg', 'helpdesk@ccn.com.sg', 'jaysontandres@outlook.com', 'rafael.lopez@hkairlines.com', 'fwops.mnl@asiagsa.com');
        $CC = array('keioperez@tam.group', 'johnchavez@tam.group', 'helpdesk@intercommerce.com.ph');
    } else if ($recepientEmail == 'ray.samonte@aircargopartners.net') {
        if ($Customs_office_segment == 'P07B') { //CEBU

            // $CC = array('s.rabanes@ecsgroup.aero', 'a.bejerano@ecsgroup.aero', 'helpdesk@intercommerce.com.ph', 'cs1@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg','helpdesk@ccn.com.sg', 'qr-cargo_ceb@pagss.com', 'f_gabalones@pagss.com', 'Cargo_ceb@pagss.com','d_deligos@pagss.com', 'ellapilongo.hrd@galcorp.com.ph', 'cargo.cs@galcorp.com.ph');
//            $CC = array(
//                'g.albao@ecsgroup.aero',
//                'm.segundo@ecsgroup.aero',
//                'e.makalintal@ecsgroup.aero',
//                // 'AVS-Philippines@ecsgroup.aero',
//                'mgorre.optns@galcorp.com.ph',
//                'mikerobles@galcorp.com.ph',
//                'ceb_qr-cargo@pagssinc.com',
//                'ceb_cargo@pagssinc.com',
//                'a_mamugay@pagssinc.com',
//                'helpdesk@intercommerce.com.ph',
//                'cargodigitalsupport@qatarairways.com.qa',
//                'cp.palomo@ecsgroup.aero',
//                'r.birondo@ecsgroup.aero',
//                'a.asegurado@ecsgroup.aero',
//                'AVS-Philippines@ecsgroup.aero',
//                'Galco.cs@galcorp.com.ph',
//                'K_suzon@pagssinc.com',
//            );
            $CC = array('helpdesk@intercommerce.com.ph', 'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'ceb_cargo@pagssinc.com', 'ceb_qr-cargo@pagssince.com', 'galco.cs@galcorp.com.ph', 'cargodigitalsupport@qatarairways.com.qa', 'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'mnlsales@ph.qatarairways.com', 'ceb_cargo@pagssinc.com', 'ceb_qr-cargo@pagssince.com', 'galco.cs@galcorp.com.ph');

        } else if ($Customs_office_segment == 'P14') { //CLARK

//            $CC = array(
//                'e.makalintal@ecsgroup.aero',
//                'j.enriquez@ecsgroup.aero',
//                'helpdesk@intercommerce.com.ph',
//                'cs1@intercommerce.com.ph',
//                'white_loh@ccn.com.sg',
//                'karen_malang@ccn.com.sg',
//                'helpdesk@ccn.com.sg',
//                'customssupport@ccn.com.sg',
//                'cargodigitalsupport@qatarairways.com.qa'
//            );
            $CC = array('helpdesk@intercommerce.com.ph', 'joenriquez@ph.qatarairways.com', 'emakalintal@ph.qatarairways.com', 'nbetasolo@ph.qatarairways.com', 'josfernandez@ph.qatarairways.com', 'fverendia@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'esortiz@cargohaus.com', 'lenie.santos@cargohaus.com', 'chicrk.customerservice@cargohaus.com', 'lemuel.ang@cargohaus.com' , 'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com', 'cargodigitalsupport@qatarairways.com.qa', 'joenriquez@ph.qatarairways.com', 'emakalintal@ph.qatarairways.com', 'nbetasolo@ph.qatarairways.com', 'josfernandez@ph.qatarairways.com', 'fverendia@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'mnlsales@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'esortiz@cargohaus.com', 'lenie.santos@cargohaus.com', 'chicrk.customerservice@cargohaus.com', 'lemuel.ang@cargohaus.com');
        } else if ($Customs_office_segment == 'P03') { //MANILA

//            $CC = array(
//                'cargoteam@dnata.com.ph',
//                'j.james@ecsgroup.aero',
//                'helpdesk@intercommerce.com.ph',
//                'cs1@intercommerce.com.ph',
//                'white_loh@ccn.com.sg',
//                'karen_malang@ccn.com.sg',
//                'helpdesk@ccn.com.sg',
//                'customssupport@ccn.com.sg',
//                'AVS-Philippines@ecsgroup.aero',
//                'cargodigitalsupport@qatarairways.com.qa'
//            );
            $CC = array('helpdesk@intercommerce.com.ph', 'emakalintal@ph.qatarairways.com', 'josfernandez@ph.qatarairways.com', 'joenriquez@ph.qatarairways.com', 'nbetasolo@ph.qatarairways.com', 'fverendia@ph.qatarairways.com', 'galbao@ph.qatarairways.com', 'sopenaranda@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'cargoteam@dnata.com.ph', 'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com', 'cargodigitalsupport@qatarairways.com.qa', 'emakalintal@ph.qatarairways.com', 'josfernandez@ph.qatarairways.com', 'joenriquez@ph.qatarairways.com', 'nbetasolo@ph.qatarairways.com', 'fverendia@ph.qatarairways.com', 'galbao@ph.qatarairways.com', 'sopenaranda@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'mnlsales@ph.qatarairways.com', 'cargoteam@dnata.com.ph');

        } else if ($Customs_office_segment == 'P12AB') { //DAVAO
            $CC = array('helpdesk@intercommerce.com.ph', 'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'dvoops@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'dvo.ops@cargohaus.com', 'cargodigitalsupport@qatarairways.com.qa', 'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com', 'cebops@ph.qatarairways.com', 'cebcs@ph.qatarairways.com', 'dvoops@ph.qatarairways.com', 'mnlcs@ph.qatarairways.com', 'mnlops@ph.qatarairways.com', 'mnlsales@ph.qatarairways.com', 'dvo.ops@cargohaus.com');
        } else {
            $CC = array(
                'j.james@ecsgroup.aero',
                'helpdesk@intercommerce.com.ph',
                'cs1@intercommerce.com.ph',
                'white_loh@ccn.com.sg',
                'karen_malang@ccn.com.sg',
                'helpdesk@ccn.com.sg',
                'customssupport@ccn.com.sg',
                'cargodigitalsupport@qatarairways.com.qa',
                'a.asegurado@ecsgroup.aero',
                'cp.palomo@ecsgroup.aero',
                'r.birondo@ecsgroup.aero',
                'AVS-Philippines@ecsgroup.aero',
                'rbirondo@ph.qatarairways.com', 'aasegurado@ph.qatarairways.com', 'jenfernandez@ph.qatarairways.com',
            );
        }

    } else if ($recepientEmail == 'wlk@jejuaircargo.com') {
        $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'aldrinrodrin.mnl@asiagsa.com', 'customssupport@ccn.com.sg', 'fwops.mnl@asiagsa.com');
    } else if ($recepientEmail == 'import_ops@miascor.com') {
        $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'jennifer.portillo@united.com', 'customssupport@ccn.com.sg');
    } else if ($recepientEmail == 'randy1@flyasiana.com') {
        $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'vivien@flyaiana.com', 'tpcarlo@flyasiana.com', 'customssupport@ccn.com.sg', 'randyalejandroivfranco@gmail.com', 'randy1@asianapartner.com', 'tpcarlo@asianapartner.com', 'asianacargomnl@yahoo.com', 'israelynclino@flyasiana.com', 'edelynp16@gmail.com', 'ozcargoceb@gmail.com', 'vivien@flyasiana.com', 'amiel@flyasiana.com', 'cargo.crk@tass.com.ph');
    } else if ($recepientEmail == 'mnlffku@kuwaitairways.com') {
        $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'Nilou.Urmeneta@kuwaitairways.com', 'ku-cargo_mnl@pagss.com', 'Harold.Bautista@kuwaitairways.com', 'customssupport@ccn.com.sg', 'd.ortiz@kuwaitairways.com', 'j.hilado@kuwaitairways.com');
    } else if ($recepientEmail == 'ssantos@holidaytours.net') {
        if ($Customs_office_segment == 'P14') {

            $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'customssupport@ccn.com.sg', 'cmontierro@holidaytours.net', 'cargo_crk@pagss.com', 'crk_cargo@pagssinc.com', 'darielkim1893@yahoo.com');

        } else {

            $CC = array('helpdesk@intercommerce.com.ph', 'white_loh@ccn.com.sg', 'karen_malang@ccn.com.sg', 'helpdesk@ccn.com.sg', 'customssupport@ccn.com.sg', 'cmontierro@holidaytours.net', 'jtitco@holidaytours.net', 'abalibat@holidaytours.net', 'qffreight-mnl@holidaytours.net', 'importpagssmnl@gmail.com', 'dhu@paircargo.com');

        }

    }elseif ($recepientEmail == 'mnlffjx@starlux-airlines.com') {
        $CC = array(
            'white_loh@ccn.com.sg',
            'karen_malang@ccn.com.sg',
            'helpdesk@ccn.com.sg',
            'customssupport@ccn.com.sg',
            'helpdesk@intercommerce.com.ph',
        );
    } elseif ($recepientEmail == 'jonathanmartillana.mnl@asiagsa.com') {
        $CC = array(
            'jaysonandres.mnl@asiagsa.com',
            'johnadorza.mnl@asiagsa.com',
            'fwops.mnl@asiagsa.com',
            'customssupport@ccn.com.sg',
            'helpdesk@intercommerce.com.ph',
        );
    } elseif ($recepientEmail == 'mnlmh@tam.group') {
        $CC = array(
            'jerielmallari@tam.group',
            'paulranas@tam.group',
            'josephcaya@tam.group',
            'jeffersonfermagolfo@tam.group',
            'lutherromero@tam.group',
			'francecabalag@tam.group',
			'johnadorza@tam.group',
            'helpdesk@intercommerce.com.ph',
        );
    }

    //  elseif ($recepientEmail == 'jaysonandres.mnl@asiagsa.com') { //01-07-2026
    //     $CC = array(
    //         'helpdesk@intercommerce.com.ph',
    //         'white_loh@ccn.com.sg',
    //         'karen_malang@ccn.com.sg',
    //         'helpdesk@ccn.com.sg',
    //         'customssupport@ccn.com.sg',
    //         'fwops.mnl@asiagsa.com'
    //     );
    // } 

    $BCC = array(
        // 'asantos@intercommerce.com.ph',
        'eatim@intercommerce.com.ph',
//        'cdeloso@intercommerce.com.ph',
        'ddulay@intercommerce.com.ph',
        // 'mguting@intercommerce.com.ph',
//        'aacielo@intercommerce.com.ph',
        'epereda@intercommerce.com.ph',
        // 'cabdonjr@intercommerce.com.ph',
        'mjbejarin@intercommerce.com.ph',
        'kmagallanes@intercommerce.com.ph',
        'ndupit@intercommerce.com.ph',
        'TBalete@intercommerce.com.ph',
        'Jlunar@intercommerce.com.ph',
        'jcorpuz@intercommerce.com.ph',
        // 'aromero@intercommerce.com.ph',
        // 'adinglasan@intercommerce.com.ph',
        // 'kcando@intercommerce.com.ph',
        // 'jmdeguzman@intercommerce.com.ph',
        'jmanalo@intercommerce.com.ph',
        // 'jbuenafe@intercommerce.com.ph',
        // 'jtamares@intercommerce.com.ph',
        'eestrella@intercommerce.com.ph',
        // 'mmagtaas@intercommerce.com.ph',
        'jbaldon@intercommerce.com.ph',
        'ctarrayo@intercommerce.com.ph',
        // 'kmanguerra@intercommerce.com.ph',
    );  //Change to

    if ($EManCCNFunc->SendEmailNotification($recepientEmail, $CC, $BCC, $recepientName, $subject, $htmlMessage)) {
        echo "email success \r\n";
        return true;
    }
    echo "email error \r\n";
    return false;
}

function SuccessWErrLogGen($RegNo, $ApplNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival, $Total_number_of_mawb, $BOLStatus, $BOLErr, $ManifestStatus)
{

    $htmlMessage = '';

    $htmlMessage .= 'File Read: MANIFEST';
    $htmlMessage .= "\n";

    if ($ManifestStatus == "SUCCESS") {
        $htmlMessage .= 'Status: SUCCESS';
    } else {
        $htmlMessage .= 'Status: ERROR';
        $htmlMessage .= "\n";
        $htmlMessage .= 'Error: ' . $ManifestStatus;
    }

    $htmlMessage .= "\n";

    $htmlMessage .= "\n";
    $htmlMessage .= 'Application No: ' . $ApplNo;
    $htmlMessage .= "\n";
    $htmlMessage .= 'Registry Number: ' . $RegNo;
    $htmlMessage .= "\n";
    $htmlMessage .= 'Port: ' . $Customs_office_segment;
    $htmlMessage .= "\n";
    $htmlMessage .= 'Arrival Date: ' . $Date_of_arrival;
    $htmlMessage .= "\n";
    $htmlMessage .= 'Arrival Time: ' . $Time_of_arrival;
    $htmlMessage .= "\n";
    $htmlMessage .= 'Total BOL: ' . $Total_number_of_mawb;
    $htmlMessage .= "\n";
    $htmlMessage .= "\n";


    if (count($BOLStatus) > 0) {
        $htmlMessage .= "\n";
        $htmlMessage .= 'File Read: BOL';
        $htmlMessage .= "\n";
        foreach ($BOLStatus as $bol) {

            if (count($bol) == 4) {
                //WITH MISSING FIELD AT BOL

                if ($bol[0] == '' && $bol[0] == NULL) {
                    $htmlMessage .= "\n";
                    $htmlMessage .= "No Specified BL Number";
                } else {
                    $htmlMessage .= "\n";
                    $htmlMessage .= "BL Number: " . $bol[0];

                }

                $htmlMessage .= "\n";
                $htmlMessage .= "Goods Description: " . $bol[3];
                $htmlMessage .= "\n";
                $htmlMessage .= 'Status: <b>ERROR</b>';
                $htmlMessage .= "\n";
                $htmlMessage .= 'Error: <b>' . $bol[1] . '</b>';
                $htmlMessage .= "\n";

                $errFields = $bol[2];

                if (count($errFields) > 0) {
                    $ctr = 1;
                    foreach ($errFields as $field) {
                        $htmlMessage .= $ctr . '. ' . $field;
                        $htmlMessage .= "\n";
                        $ctr++;
                    }
                }


            } else {

                //FOR NO MISSING FIELD AT BOL
                $htmlMessage .= "\n";
                $htmlMessage .= "BL Number: " . $bol[0];
                $htmlMessage .= "\n";
                $htmlMessage .= "Goods Description: " . $bol[2];
                $htmlMessage .= "\n";
                if (isset($bol[1]) && $bol[1] == "SUCCESS") {
                    $htmlMessage .= 'Status: SUCCESS';
                } elseif (isset($bol[1]) && $bol[1] == "Duplicate Entry") {
                    $htmlMessage .= 'Status: ERROR';
                    $htmlMessage .= "\n";
                    $htmlMessage .= 'Error: ' . $bol[1];
                }
                $htmlMessage .= "\n";
            }


        }

    }

    $htmlMessage .= "\n";

    if (count($BOLErr) > 0) {

        $htmlMessage .= "\n\nOTHER ERROR(S) FOUND\n";

        foreach ($BOLErr as $err) {
            $htmlMessage .= "\n" . $err . "\n";
        }

    }


    //die($htmlMessage);

    return $htmlMessage;
}

function MoveXMLFileGenSuccess($helper, $currentDirectory, $oldDir, $newDIR, $file, $NewfileName)
{
    //CREATE OLD FOLDER
    if (!$helper->check_file_exists($currentDirectory . $oldDir)) {

        $helper->create_dir($currentDirectory . $oldDir);

    }

    //INSIDE OLD FOLDER
    if (!$helper->check_file_exists($currentDirectory . $oldDir . $newDIR)) {

        $helper->create_dir($currentDirectory . $oldDir . $newDIR);

    }

    //NOW MOVE IT TO OLD FOLDER

    $helper->move_file($currentDirectory . $file, $currentDirectory . $oldDir . $newDIR . "/" . $NewfileName);

    return true;

}

//======================END FUNCTIONS=======================


//** READ DATA
if ($helper->check_file_exists($getFLocation)) {

    //GET ALL DIRECTORIES
    $dirs = $helper->scan_dir($getFLocation);
    //print_r($dirs);
    //die();

    //LOOP ALL DIRECTORIES
    foreach ($dirs as $dir) {

        if ($dir != '.' && $dir != '..') {

            if ($helper->check_dir($getFLocation . $dir)) {
                //die($dir);

                echo "\n\n=== DIRECTORY: $dir ====\n\n";

                $currentDirectory = $getFLocation . $dir . "/";
                //die($currentDirectory);
                //echo $currentDirectory.$file."\n";

                //GET ALL FILES IN THE DIRECTORY
                $files = $helper->scan_dir($currentDirectory);
                //print_r($files);
                //die();

                //LOOP ALL FILES IN THE DIRECTORY
                foreach ($files as $file) {

                    if ($file != '.' && $file != '..') {
                        if (!$helper->check_dir($currentDirectory . $file)) {
                            //echo $currentDirectory.$file."\n";


                            //READ THE XML FILE

                            $fileRead = $helper->file_open($currentDirectory . $file);

                            //die($fileRead);

                            echo "\n\nREAD DATA FROM $file \n\n";

                            $xml = simplexml_load_string($fileRead) or die("Error: Cannot create object");

                            if ($xml === false) {
                                echo "Failed loading XML: ";
                                foreach (libxml_get_errors() as $error) {
                                    echo "<br>", $error->message;
                                }
                            } else {
                                $xml = json_encode($xml);
                                $xml = json_decode($xml, true);

                                /*echo "<pre>";
                                print_r($xml);
                                echo "</pre>";
                                die();*/


                                //FOR MANIFEST VARIABLES
                                $RegNo = "";
                                $Customs_office_segment = "";
                                $Last_Date_Departure = "";
                                $Date_of_arrival = "";
                                $Time_of_arrival = "";
                                $DepLCode = "";
                                $DesLCode = "";
                                $CSCode = "";
                                $CSName = "";
                                $CSAddress1 = "";
                                $CSAddress2 = "";
                                $CSAddress3 = "";
                                $CSAddress4 = "";
                                $ModeTS = "";
                                $NationalTS = "";
                                $Place_of_transporter = "";
                                $Registration_number = "";
                                $Registration_date = "";
                                $FlightNo = "";
                                $Net_tonnage = "";
                                $Gross_tonnage = "";
                                $Total_number_of_mawb = "";


                                //FOR BOL
                                $BLCustoms_office_segment = "";
                                $Line_number = "";
                                $AWBReference = "";
                                $AWBType = "";
                                $AWB_Nature = "";
                                $Unique_carrier_reference = "";
                                $SName = "";
                                $SAddress1 = "";
                                $SAddress2 = "";
                                $SAddress3 = "";
                                $SAddress4 = "";
                                $CName = "";
                                $CAddress1 = "";
                                $CAddress2 = "";
                                $CAddress3 = "";
                                $CAddress4 = "";
                                $NName = "";
                                $NAddress1 = "";
                                $NAddress2 = "";
                                $NAddress3 = "";
                                $NAddress4 = "";
                                $Place_of_loading_segment = "";
                                $Place_of_unloading_segment = "";
                                $Package_type_code = "";
                                $Number_of_packages = "";
                                $Total_gross_mass_manifested = "";
                                $Volume_in_cubic_meters = "";
                                $Marking1 = "";
                                $Goods1 = "";
                                $FreightAmount = "";
                                $InsuranceAmount = "";


                                //$mantype = "AL";
                                $status = "Created";
                                $DefaultVal = "1";
                                $Currency = "USD";
                                $BLStatus = "4";
                                $cltcode = "20150611";
                                $userid = "INS2001";
                                $emailadd = "helpdesk@intercommerce.com.ph";
                                $LGoods = '';
                                $Total_containers = 0;
                                $FreightInd = 'P';

                                $XMLErr = array();
                                $BOLXMLErr = array();

                                $ReadBOLFlag = 0;
                                $ErrorBOLFlag = 0;


                                // FOR AUTO UPLOAD INDICATOR
                                $auto_upload_status = $file;

                                //-------------------------GENERATE Application Number-------------
                                date_default_timezone_set('Asia/Manila');
                                $cdate = date('Y-m-d H:i:s');


                                $newDIR = date('Y-m-d');

                                $ApplNo = "AL" . substr(time(), 4) . rand(1000, 9999);

                                //echo $ApplNo;
                                //------------------------END GENERATE Application Number----------


                                // -------------------START OF 5JXML---------------------

                                if (isset($xml["TWM_Manifest"]) || isset($xml["TWM_MANIFEST"])) {

                                    if (isset($xml["TWM_Manifest"])) {

                                        $Manifest = $xml["TWM_Manifest"];
                                    } else if (isset($xml["TWM_MANIFEST"])) {

                                        $Manifest = $xml["TWM_MANIFEST"];
                                    }


                                    //print_r($Manifest);

                                    //die();
                                    if (isset($Manifest["Identification_segment"]["Registry_number"]) && !is_array($Manifest["Identification_segment"]["Registry_number"])) {

                                        $RegNo = $Manifest["Identification_segment"]["Registry_number"];

                                        //** change 7CA -> JJA REGISTRY No.
                                        if ((substr($RegNo, 0, 3)) == "7CA") {
                                            $RegNo = "JJA" . substr($RegNo, 3);
                                        }

                                        //echo $RegNo;

                                    }
                                    // else if (isset($Manifest["IDENTIFICATION_SEGMENT"]["REGISTRY_NUMBER"]) && !is_array($Manifest["IDENTIFICATION_SEGMENT"]["REGISTRY_NUMBER"])){
                                    // $RegNo = $Manifest["IDENTIFICATION_SEGMENT"]["REGISTRY_NUMBER"];
                                    // }
                                    else {

                                        //array_push($XMLErr, "Missing Registry_number");

                                    }


                                    if (isset($Manifest["Identification_segment"]["Customs_office_segment"]["Code"]) && !is_array($Manifest["Identification_segment"]["Customs_office_segment"]["Code"])) {
                                        $Customs_office_segment = $Manifest["Identification_segment"]["Customs_office_segment"]["Code"];
                                        //echo $Customs_office_segment;

                                    } else if (isset($Manifest["IDENTIFICATION_SEGMENT"]["CUSTOMS_OFFICE_SEGMENT"]["CODE"]) && !is_array($Manifest["IDENTIFICATION_SEGMENT"]["CUSTOMS_OFFICE_SEGMENT"]["CODE"])) {

                                        $Customs_office_segment = $Manifest["IDENTIFICATION_SEGMENT"]["CUSTOMS_OFFICE_SEGMENT"]["CODE"];
                                    } else {
                                        array_push($XMLErr, "Customs_office_segment");
                                    }


                                    if (isset($Manifest["General_segment"]["Totals_segment"]["Total_number_of_bols"]) && !is_array($Manifest["General_segment"]["Totals_segment"]["Total_number_of_bols"])) {
                                        $Total_number_of_mawb = $Manifest["General_segment"]["Totals_segment"]["Total_number_of_bols"];
                                        //echo $Total_number_of_mawb;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TOTALS_SEGMENT"]["TOTAL_NUMBER_OF_BOLS"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TOTALS_SEGMENT"]["TOTAL_NUMBER_OF_BOLS"])) {

                                        $Total_number_of_mawb = $Manifest["GENERAL_SEGMENT"]["TOTALS_SEGMENT"]["TOTAL_NUMBER_OF_BOLS"];
                                    } else {
                                        array_push($XMLErr, "Total_number_of_bols");
                                    }


                                    if (isset($Manifest["General_segment"]["Last_discharge"]) && !is_array($Manifest["General_segment"]["Last_discharge"])) {
                                        $Last_Date_Departure = $Manifest["General_segment"]["Last_discharge"];
                                        //echo $Last_Date_Departure;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["LAST_DISCHARGE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["LAST_DISCHARGE"])) {

                                        $Last_Date_Departure = $Manifest["GENERAL_SEGMENT"]["LAST_DISCHARGE"];
                                    } else {
                                        array_push($XMLErr, "Last_discharge");
                                    }


                                    if (isset($Manifest["General_segment"]["Arrival_segment"]["Date_of_arrival"]) && !is_array($Manifest["General_segment"]["Arrival_segment"]["Date_of_arrival"])) {
                                        $Date_of_arrival = $Manifest["General_segment"]["Arrival_segment"]["Date_of_arrival"];
                                        //echo $Date_of_arrival;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["ARRIVAL_SEGMENT"]["DATE_OF_ARRIVAL"]) && !is_array($Manifest["GENERAL_SEGMENT"]["ARRIVAL_SEGMENT"]["DATE_OF_ARRIVAL"])) {

                                        $Date_of_arrival = $Manifest["GENERAL_SEGMENT"]["ARRIVAL_SEGMENT"]["DATE_OF_ARRIVAL"];
                                    } else {
                                        array_push($XMLErr, "Date_of_arrival");
                                    }


                                    if (isset($Manifest["General_segment"]["Arrival_segment"]["Time_of_arrival"]) && !is_array($Manifest["General_segment"]["Arrival_segment"]["Time_of_arrival"])) {
                                        $Time_of_arrival = $Manifest["General_segment"]["Arrival_segment"]["Time_of_arrival"];
                                        //echo $Time_of_arrival;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["ARRIVAL_SEGMENT"]["TIME_OF_ARRIVAL"]) && !is_array($Manifest["GENERAL_SEGMENT"]["ARRIVAL_SEGMENT"]["TIME_OF_ARRIVAL"])) {

                                        $Time_of_arrival = $Manifest["GENERAL_SEGMENT"]["ARRIVAL_SEGMENT"]["TIME_OF_ARRIVAL"];
                                    } else {
                                        array_push($XMLErr, "Time_of_arrival");
                                    }


                                    if (isset($Manifest["General_segment"]["Departure_segment"]["Code"]) && !is_array($Manifest["General_segment"]["Departure_segment"]["Code"])) {
                                        $DepLCode = $Manifest["General_segment"]["Departure_segment"]["Code"];
                                        //echo $DepLCode;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["DEPARTURE_SEGMENT"]["CODE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["DEPARTURE_SEGMENT"]["CODE"])) {

                                        $DepLCode = $Manifest["GENERAL_SEGMENT"]["DEPARTURE_SEGMENT"]["CODE"];
                                    } else {
                                        array_push($XMLErr, "Departure_segment");
                                    }


                                    if (isset($Manifest["General_segment"]["Destination_segment"]["Code"]) && !is_array($Manifest["General_segment"]["Destination_segment"]["Code"])) {
                                        $DesLCode = $Manifest["General_segment"]["Destination_segment"]["Code"];
                                        //echo $DesLCode;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["DESTINATION_SEGMENT"]["CODE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["DESTINATION_SEGMENT"]["CODE"])) {

                                        $DesLCode = $Manifest["GENERAL_SEGMENT"]["DESTINATION_SEGMENT"]["CODE"];
                                    } else {
                                        array_push($XMLErr, "Destination_segment");
                                    }


                                    //-----------GET CARRIER INFO------------------
                                    if (isset($Manifest["General_segment"]["Carrier_segment"]["Code"]) && !is_array($Manifest["General_segment"]["Carrier_segment"]["Code"])) {

                                        $CarrierCode = $Manifest["General_segment"]["Carrier_segment"]["Code"];

                                        if ($CarrierCode == "7C") {
                                            $CarrierCode = "JJA";
                                        }

                                        //echo $CarrierCode;

                                        $getCarrier = $EManCCNFunc->GETCarrierInfo($CarrierCode);

                                        if (count($getCarrier) > 0) {
                                            foreach ($getCarrier as $key => $row) {
                                                $CSCode = $row['Code'];
                                                $CSName = $row['Name'];
                                                $CSAddress1 = $row['Addr1'];
                                                $CSAddress2 = $row['Addr2'];
                                                $CSAddress3 = $row['Addr3'];
                                                $CSAddress4 = $row['Addr4'];
                                            }
                                        }

                                        //var_dump($getCarrier);

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["CARRIER_SEGMENT"]["CODE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["CARRIER_SEGMENT"]["CODE"])) {

                                        $CarrierCode = $Manifest["GENERAL_SEGMENT"]["CARRIER_SEGMENT"]["CODE"];

                                        if ($CarrierCode == "7C") {
                                            $CarrierCode = "JJA";
                                        }

                                        //echo $CarrierCode;

                                        $getCarrier = $EManCCNFunc->GETCarrierInfo($CarrierCode);

                                        if (count($getCarrier) > 0) {
                                            foreach ($getCarrier as $key => $row) {
                                                $CSCode = $row['Code'];
                                                $CSName = $row['Name'];
                                                $CSAddress1 = $row['Addr1'];
                                                $CSAddress2 = $row['Addr2'];
                                                $CSAddress3 = $row['Addr3'];
                                                $CSAddress4 = $row['Addr4'];
                                            }
                                        }

                                    } else {
                                        array_push($XMLErr, "Carrier Code");
                                    }
                                    //-----------END CARRIER INFO------------------

                                    if (isset($Manifest["General_segment"]["Transport_segment"]["Name_of_transporter"]) && !is_array($Manifest["General_segment"]["Transport_segment"]["Name_of_transporter"])) {

                                        $FlightNo = $Manifest["General_segment"]["Transport_segment"]["Name_of_transporter"];


                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["NAME_OF_TRANSPORTER"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["NAME_OF_TRANSPORTER"])) {

                                        $FlightNo = $Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["NAME_OF_TRANSPORTER"];


                                    } else {
                                        array_push($XMLErr, "FlightNo");
                                    }


                                    if (isset($Manifest["General_segment"]["Transport_segment"]["Place_of_transporter"]) && !is_array($Manifest["General_segment"]["Transport_segment"]["Place_of_transporter"])) {
                                        $Place_of_transporter = $Manifest["General_segment"]["Transport_segment"]["Place_of_transporter"];


                                        //-----------GET CTY INFO------------------
                                        $getCty = $EManCCNFunc->GETCtyInfo($Place_of_transporter);

                                        if (count($getCty) > 0) {
                                            foreach ($getCty as $key => $row) {
                                                $Place_of_transporter = $row['cty_dsc'];
                                            }

                                        }

                                        //-----------END CTY INFO------------------

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["PLACE_OF_TRANSPORTER"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["PLACE_OF_TRANSPORTER"])) {

                                        $Place_of_transporter = $Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["PLACE_OF_TRANSPORTER"];


                                        //-----------GET CTY INFO------------------
                                        $getCty = $EManCCNFunc->GETCtyInfo($Place_of_transporter);

                                        if (count($getCty) > 0) {
                                            foreach ($getCty as $key => $row) {
                                                $Place_of_transporter = $row['cty_dsc'];
                                            }

                                        }

                                    } else {
                                        //array_push($XMLErr, "Place_of_transporter");
                                    }


                                    if (isset($Manifest["General_segment"]["Transport_segment"]["Mode_of_transport_segment"]["Code"]) && !is_array($Manifest["General_segment"]["Transport_segment"]["Mode_of_transport_segment"]["Code"])) {
                                        $ModeTS = $Manifest["General_segment"]["Transport_segment"]["Mode_of_transport_segment"]["Code"];
                                        //echo $ModeTS;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["MODE_OF_TRANSPORT_SEGMENT"]["CODE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["MODE_OF_TRANSPORT_SEGMENT"]["CODE"])) {

                                        $ModeTS = $Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["MODE_OF_TRANSPORT_SEGMENT"]["CODE"];
                                    } else {
                                        array_push($XMLErr, "Mode_of_transport_segment");
                                    }


                                    if (isset($Manifest["General_segment"]["Transport_segment"]["Nationality_of_transport_segment"]["Code"]) && !is_array($Manifest["General_segment"]["Transport_segment"]["Nationality_of_transport_segment"]["Code"])) {
                                        $NationalTS = $Manifest["General_segment"]["Transport_segment"]["Nationality_of_transport_segment"]["Code"];
                                        //echo $NationalTS;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["NATIONALITY_OF_TRANSPORT_SEGMENT"]["CODE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["NATIONALITY_OF_TRANSPORT_SEGMENT"]["CODE"])) {

                                        $NationalTS = $Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["NATIONALITY_OF_TRANSPORT_SEGMENT"]["CODE"];
                                    } else {
                                        array_push($XMLErr, "Nationality_of_transport_segment");
                                    }


                                    if (isset($Manifest["General_segment"]["Transport_segment"]["Transporter_registration_segment"]["Registration_number"]) && !is_array($Manifest["General_segment"]["Transport_segment"]["Transporter_registration_segment"]["Registration_number"])) {
                                        $Registration_number = $Manifest["General_segment"]["Transport_segment"]["Transporter_registration_segment"]["Registration_number"];
                                        //echo $Registration_number;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["TRANSPORTER_REGISTRATION_SEGMENT"]["REGISTRATION_NUMBER"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["TRANSPORTER_REGISTRATION_SEGMENT"]["REGISTRATION_NUMBER"])) {

                                        $Registration_number = $Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["TRANSPORTER_REGISTRATION_SEGMENT"]["REGISTRATION_NUMBER"];
                                    } else {
                                        //array_push($XMLErr, "Registration_number");
                                        $Registration_number = "";
                                    }


                                    if (isset($Manifest["General_segment"]["Transport_segment"]["Transporter_registration_segment"]["Registration_date"]) && !is_array($Manifest["General_segment"]["Transport_segment"]["Transporter_registration_segment"]["Registration_date"])) {
                                        $Registration_date = $Manifest["General_segment"]["Transport_segment"]["Transporter_registration_segment"]["Registration_date"];
                                        //echo $Registration_date;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["TRANSPORTER_REGISTRATION_SEGMENT"]["REGISTRATION_DATE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["TRANSPORTER_REGISTRATION_SEGMENT"]["REGISTRATION_DATE"])) {

                                        $Registration_date = $Manifest["GENERAL_SEGMENT"]["TRANSPORT_SEGMENT"]["TRANSPORTER_REGISTRATION_SEGMENT"]["REGISTRATION_DATE"];
                                    } else {
                                        //array_push($XMLErr, "Registration_date");
                                        $Registration_date = $cdate;
                                    }


                                    if (isset($Manifest["General_segment"]["Tonnage_segment"]["Net_tonnage"]) && !is_array($Manifest["General_segment"]["Tonnage_segment"]["Net_tonnage"])) {
                                        $Net_tonnage = $Manifest["General_segment"]["Tonnage_segment"]["Net_tonnage"];
                                        //echo $Net_tonnage;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TONNAGE_SEGMENT"]["NET_TONNAGE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TONNAGE_SEGMENT"]["NET_TONNAGE"])) {

                                        $Net_tonnage = $Manifest["GENERAL_SEGMENT"]["TONNAGE_SEGMENT"]["NET_TONNAGE"];
                                    } else {
                                        array_push($XMLErr, "Net_tonnage");
                                    }


                                    if (isset($Manifest["General_segment"]["Tonnage_segment"]["Gross_tonnage"]) && !is_array($Manifest["General_segment"]["Tonnage_segment"]["Gross_tonnage"])) {
                                        $Gross_tonnage = $Manifest["General_segment"]["Tonnage_segment"]["Gross_tonnage"];
                                        //echo $Gross_tonnage;

                                    } else if (isset($Manifest["GENERAL_SEGMENT"]["TONNAGE_SEGMENT"]["GROSS_TONNAGE"]) && !is_array($Manifest["GENERAL_SEGMENT"]["TONNAGE_SEGMENT"]["GROSS_TONNAGE"])) {

                                        $Gross_tonnage = $Manifest["GENERAL_SEGMENT"]["TONNAGE_SEGMENT"]["GROSS_TONNAGE"];
                                    } else {
                                        array_push($XMLErr, "Gross_tonnage");
                                    }


                                    //-------------GET REG ACCOUNT------------------------

                                    // if ($Customs_office_segment == 'P03') {

                                    // $SenderIATAID = '4ZON170726';

                                    // }
                                    // if ($Customs_office_segment == 'P12AB') {

                                    // $SenderIATAID = 'WHOS171129';

                                    // }
                                    // if ($Customs_office_segment == 'P06AA') {

                                    // $SenderIATAID = 'EJCQ171218';

                                    // }
                                    // if ($Customs_office_segment == 'P07B') {

                                    // $SenderIATAID = '3XPU180209';

                                    // }
                                    // if ($Customs_office_segment == 'P14') {

                                    // $SenderIATAID = 'BGH1963N';

                                    // }
                                    // if ($Customs_office_segment == 'P07B') {

                                    // $SenderIATAID = '3XPU180209';

                                    // }
                                    $SenderIATAID = 'TESTA';

                                    $UserArr = $EManCCNFunc->GetUser($SenderIATAID);

                                    if ($UserArr != null || count($userid)) {
                                        //$cltcode  = $UserArr[0]['CarrierCode'];
                                        $userid = $UserArr[0]['id'];
                                        $emailadd = $UserArr[0]['email'];

                                        //die($emailadd);
                                    }

                                    $cltcode = 'TESTA';
                                    //-------------END REG ACCOUT------------------------

                                    // END 5jXML
                                }


                                if (isset($xml["General_Info"]) || isset($xml["General_Info"])) {

                                    // XML FOR CCN

                                    //========================================MANIFEST INFO========================================================================================

                                    $Manifest = isset($xml["General_Info"]) ? $xml["General_Info"] : array();


                                    if (isset($Manifest["Registry_number"]) && !is_array($Manifest["Registry_number"])) {
                                        $RegNo = $Manifest["Registry_number"];

                                        //** change 7CA -> JJA REGISTRY No.
                                        if ((substr($RegNo, 0, 3)) == "7CA") {
                                            $RegNo = "JJA" . substr($RegNo, 3);
                                        }

                                        //echo $RegNo;

                                    } else {
                                        array_push($XMLErr, "Registry_number");
                                    }


                                    if (isset($Manifest["Customs_office_segment"]) && !is_array($Manifest["Customs_office_segment"])) {
                                        $Customs_office_segment = $Manifest["Customs_office_segment"];
                                        //echo $Customs_office_segment;

                                    } else {
                                        array_push($XMLErr, "Customs_office_segment");
                                    }


                                    if (isset($Manifest["Last_Date_Departure"]) && !is_array($Manifest["Last_Date_Departure"])) {
                                        $Last_Date_Departure = $Manifest["Last_Date_Departure"];
                                        //echo $Last_Date_Departure;

                                    } else {
                                        array_push($XMLErr, "Last_Date_Departure");
                                    }


                                    if (isset($Manifest["Date_of_arrival"]) && !is_array($Manifest["Date_of_arrival"])) {
                                        $Date_of_arrival = $Manifest["Date_of_arrival"];
                                        //echo $Date_of_arrival;

                                    } else {
                                        array_push($XMLErr, "Date_of_arrival");
                                    }


                                    if (isset($Manifest["Time_of_arrival"]) && !is_array($Manifest["Time_of_arrival"])) {
                                        $Time_of_arrival = $Manifest["Time_of_arrival"];
                                        //echo $Time_of_arrival;

                                    } else {
                                        array_push($XMLErr, "Time_of_arrival");
                                    }


                                    if (isset($Manifest["Departure_location"]["Code"]) && !is_array($Manifest["Departure_location"]["Code"])) {
                                        $DepLCode = $Manifest["Departure_location"]["Code"];
                                        //echo $DepLCode;

                                    } else {
                                        array_push($XMLErr, "Departure_location");
                                    }


                                    if (isset($Manifest["Destination_location"]["Code"]) && !is_array($Manifest["Destination_location"]["Code"])) {
                                        $DesLCode = $Manifest["Destination_location"]["Code"];
                                        //echo $DesLCode;

                                    } else {
                                        array_push($XMLErr, "Destination_location");
                                    }


                                    //-----------GET CARRIER INFO------------------
                                    if (isset($Manifest["Code"]) && !is_array($Manifest["Code"])) {

                                        $CarrierCode = $Manifest["Code"];

                                        if ($CarrierCode == "7C") {
                                            $CarrierCode = "JJA";
                                        }

                                        //echo $CarrierCode;

                                        $getCarrier = $EManCCNFunc->GETCarrierInfo($CarrierCode);

                                        if (count($getCarrier) > 0) {
                                            foreach ($getCarrier as $key => $row) {
                                                $CSCode = $row['Code'];
                                                $CSName = $row['Name'];
                                                $CSAddress1 = $row['Addr1'];
                                                $CSAddress2 = $row['Addr2'];
                                                $CSAddress3 = $row['Addr3'];
                                                $CSAddress4 = $row['Addr4'];
                                            }
                                        }

                                        //var_dump($getCarrier);

                                    } else {
                                        array_push($XMLErr, "Carrier Code");
                                    }
                                    //-----------END CARRIER INFO------------------


                                    if (isset($Manifest["Transport_segment"]["Mode_of_transport_segment"]["Code"]) && !is_array($Manifest["Transport_segment"]["Mode_of_transport_segment"]["Code"])) {
                                        $ModeTS = $Manifest["Transport_segment"]["Mode_of_transport_segment"]["Code"];
                                        //echo $ModeTS;

                                    } else {
                                        array_push($XMLErr, "Mode_of_transport_segment");
                                    }


                                    if (isset($Manifest["Transport_segment"]["Nationality_of_transport_segment"]["Code"]) && !is_array($Manifest["Transport_segment"]["Nationality_of_transport_segment"]["Code"])) {
                                        $NationalTS = $Manifest["Transport_segment"]["Nationality_of_transport_segment"]["Code"];
                                        //echo $NationalTS;

                                    } else {
                                        array_push($XMLErr, "Nationality_of_transport_segment");
                                    }


                                    if (isset($Manifest["Transport_segment"]["Place_of_transporter"]) && !is_array($Manifest["Transport_segment"]["Place_of_transporter"])) {
                                        $Place_of_transporter = $Manifest["Transport_segment"]["Place_of_transporter"];


                                        //-----------GET CTY INFO------------------
                                        $getCty = $EManCCNFunc->GETCtyInfo($Place_of_transporter);

                                        if (count($getCty) > 0) {
                                            foreach ($getCty as $key => $row) {
                                                $Place_of_transporter = $row['cty_dsc'];
                                            }
                                        }

                                        //var_dump($getCty);
                                        //echo $Place_of_transporter;
                                        //-----------END CTY INFO------------------

                                    } else {
                                        array_push($XMLErr, "Place_of_transporter");
                                    }


                                    if (isset($Manifest["Transport_segment"]["Transporter_registration_segment"]["Registration_number"]) && !is_array($Manifest["Transport_segment"]["Transporter_registration_segment"]["Registration_number"])) {
                                        $Registration_number = $Manifest["Transport_segment"]["Transporter_registration_segment"]["Registration_number"];
                                        //echo $Registration_number;

                                    } else {
                                        //array_push($XMLErr, "Registration_number");
                                        $Registration_number = "";
                                    }


                                    if (isset($Manifest["Transport_segment"]["Transporter_registration_segment"]["Registration_date"]) && !is_array($Manifest["Transport_segment"]["Transporter_registration_segment"]["Registration_date"])) {
                                        $Registration_date = $Manifest["Transport_segment"]["Transporter_registration_segment"]["Registration_date"];
                                        //echo $Registration_date;

                                    } else {
                                        //array_push($XMLErr, "Registration_date");
                                        $Registration_date = $cdate;
                                    }


                                    if (isset($Manifest["FlightNo"]) && !is_array($Manifest["FlightNo"])) {
                                        $FlightNo = $Manifest["FlightNo"];
                                        //echo $FlightNo;

                                    } else {
                                        array_push($XMLErr, "FlightNo");
                                    }


                                    if (isset($Manifest["Tonnage_segment"]["Net_tonnage"]) && !is_array($Manifest["Tonnage_segment"]["Net_tonnage"])) {
                                        $Net_tonnage = $Manifest["Tonnage_segment"]["Net_tonnage"];
                                        //echo $Net_tonnage;

                                    } else {
                                        array_push($XMLErr, "Net_tonnage");
                                    }


                                    if (isset($Manifest["Tonnage_segment"]["Gross_tonnage"]) && !is_array($Manifest["Tonnage_segment"]["Gross_tonnage"])) {
                                        $Gross_tonnage = $Manifest["Tonnage_segment"]["Gross_tonnage"];
                                        //echo $Gross_tonnage;

                                    } else {
                                        array_push($XMLErr, "Gross_tonnage");
                                    }


                                    if (isset($Manifest["Total_number_of_mawb"]) && !is_array($Manifest["Total_number_of_mawb"])) {
                                        $Total_number_of_mawb = $Manifest["Total_number_of_mawb"];
                                        //echo $Total_number_of_mawb;

                                    } else {
                                        array_push($XMLErr, "Total_number_of_mawb");
                                    }


                                    //-------------GET REG ACCOUNT------------------------

                                    if (isset($xml["UserInformation"]["SenderIATAID"]) && !is_array($xml["UserInformation"]["SenderIATAID"])) {
                                        $SenderIATAID = $xml["UserInformation"]["SenderIATAID"];
                                        //echo $SenderIATAID;


                                        $UserArr = $EManCCNFunc->GetUser($SenderIATAID);
                                        //print_r($UserArr);
                                        //die();

                                        if ($UserArr != null || count($userid)) {
                                            $cltcode = $UserArr[0]['CarrierCode'];
                                            $userid = $UserArr[0]['id'];
                                            $emailadd = $UserArr[0]['email'];

                                            //die($emailadd);
                                        }


                                    } else {
                                        array_push($XMLErr, "SenderIATAID");
                                    }

                                    //-------------END REG ACCOUT------------------------
                                }        //END CCN XML


                                //MANIFEST STATUS
                                $ManifestStatus = 'SUCCESS';
                                $ManAdditionalErr = 0;

                                //IF ERROR MANIFEST ENCOUNTERED EMAIL USER
                                if (count($XMLErr) > 0) {

                                    //print_r($XMLErr);

                                    if (!sendErrorNotificationXMLGEN($EManCCNFunc, $file, $emailadd, $RegNo, $XMLErr)) {
                                        echo "Failed to send email\n";
                                    }

                                    //NOW MOVE IT TO ERROR FOLDER

                                    $NewfileName = "Manifest-Bol-Created-" . $ApplNo . "--" . $RegNo . "-" . $Customs_office_segment . "--" . $file;

                                    $txt = ErrorLogXMLGEN($RegNo, $XMLErr);

                                    if (!MoveFileXMLGEN($helper, $currentDirectory, $file, $errDir, $newDIR, $NewfileName, $txt)) {
                                        echo "Failed to move file\n";
                                    }


                                } elseif (count($XMLErr) == 0) {
                                    //CONTINUE READING
                                    //PROCEED READING XML FILE===================================


                                    //****************************************************

                                    if ($EManCCNFunc->checkifDuplicateGEN($RegNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival)) {

                                        //echo 'Duplicate';

                                        //PROCEED READING BOL XML FILE

                                        $ReadBOLFlag = 1;

                                        //TO ADD NEW BL IT NEEDS THE EXISTING APPLICATION No.
                                        $DataArr = $EManCCNFunc->GetApplNo($RegNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival);
                                        $ApplNo = isset($DataArr[0]['ApplNo']) ? $DataArr[0]['ApplNo'] : '';

                                        //FOR MANIFEST STATUS
                                        $ManifestStatus = "Duplicate Entry";
                                        $ManAdditionalErr = 1;

                                        // update manifestgen total number of awb
                                        $EManCCNFunc->updateManifestGENTotalBOL($ApplNo, $RegNo, $Total_number_of_mawb);
                                    } else {

                                        //INSERT NOW MANIFEST TO DATABASE

                                        $Last_Date_Departure = $helper->SetIfNull($Last_Date_Departure);
                                        $Date_of_arrival = $helper->SetIfNull($Date_of_arrival);
                                        $Time_of_arrival = $helper->SetIfNull($Time_of_arrival);

                                        $Registration_date = $helper->SetIfNull($Registration_date);


                                        $response = $EManCCNFunc->ManifestGen($ApplNo, $RegNo, $Customs_office_segment, $status, $Last_Date_Departure, $Date_of_arrival, $Time_of_arrival, $DepLCode, $DesLCode, $CSCode, $CSName, $CSAddress1, $CSAddress2, $CSAddress3, $CSAddress4, $ModeTS, $NationalTS, $Place_of_transporter, $Registration_number, $Registration_date, $FlightNo, $Net_tonnage, $Gross_tonnage, $Total_number_of_mawb, $Total_containers, $cltcode, $cdate, $userid, $auto_upload_status);

                                        echo $response;


                                        //========================================END MANIFEST INFO========================================================================================


                                        $ReadBOLFlag = 1;


                                    }


                                    //=========================READ BOL PART OF XML======================================================================

                                    if ($ReadBOLFlag == 1) {

                                        //========================================AWB INFO=================================================================================================

                                        $BOLErr = array();
                                        $BOLStatus = array();

                                        $AirWayBill = isset($xml["AirWayBill"]) ? $xml["AirWayBill"] : array();

                                        $CountBOL = 0;

                                        if (isset($AirWayBill[0])) {
                                            //echo "true";

                                            //MULTIPLE BL============================================================

                                            //print_r($AirWayBill[0]["AWBReference"]);
                                            //die();

                                            foreach ($AirWayBill as $bol) {

                                                //FOR STATUS OF EACH BOL
                                                $BLMsg = array();


                                                $ArrResult = ReadXMLFileBOL($bol);

                                                $BOLS = $ArrResult[0];
                                                $AWBXMLErr = $ArrResult[1];


                                                //====DISTRIBUTE ALL FROM ARRAY KEYS TO SPECIFIC VARIABLE NAME=======
                                                foreach ($BOLS as $key => $values) {
                                                    ${"$key"} = $values;
                                                }
                                                //===================================================================


                                                //PUSH ERROR TO ARR
                                                if (count($AWBXMLErr) > 0) {

                                                    //print_r($AWBXMLErr);
                                                    //die();


                                                    array_push($BLMsg, $AWBReference, "XML - Missing Information", $AWBXMLErr, $Goods1);
                                                    $ManAdditionalErr = 1;


                                                } elseif (count($AWBXMLErr) == 0) {
                                                    //****************************************************
                                                    $Port = $EManCCNFunc->getManifestGenPort($ApplNo, $RegNo);
                                                    $BLCustoms_office_segment = ($BLCustoms_office_segment) ? $BLCustoms_office_segment : $Port[0]['BOCOFC'];

                                                    if ($EManCCNFunc->checkifDuplicateBOL($AWBReference, $BLCustoms_office_segment, $RegNo)) {
                                                        //echo "duplicate";

                                                        array_push($BLMsg, $AWBReference, "Duplicate Entry", $Goods1);
                                                        $ManAdditionalErr = 1;


                                                    } else {

                                                        array_push($BLMsg, $AWBReference, "SUCCESS", $Goods1, $AWB_Nature, $CName);

                                                        $response = $EManCCNFunc->ManifestBOL($ApplNo, $RegNo, $BLCustoms_office_segment, $status, $Line_number, $AWBReference, $BLStatus, $AWBType, $AWB_Nature, $Unique_carrier_reference, $SName, $SAddress1, $SAddress2, $SAddress3, $SAddress4, $CName, $CAddress1, $CAddress2, $CAddress3, $CAddress4, $NName, $NAddress1, $NAddress2, $NAddress3, $NAddress4, $Place_of_loading_segment, $Place_of_unloading_segment, $Package_type_code, $Number_of_packages, $Total_gross_mass_manifested, $Volume_in_cubic_meters, $Marking1, $Goods1, $FreightAmount, $Currency, $InsuranceAmount, $DefaultVal, $cltcode, $cdate, $LGoods, $userid, $FreightInd, $auto_upload_status);

                                                        echo $response;

                                                    }
                                                    //========================================END AWB INFO=============================================================================================
                                                }

                                                //INSERT NOW THE STATUS OF BOL
                                                array_push($BOLStatus, $BLMsg);

                                                $CountBOL++;

                                            } //END FOR


                                            //END MULTIPLE BL====================================


                                        } else {

                                            //SINGLE BL==============================================================================================
                                            //echo "false";


                                            //print_r($AirWayBill["AWBReference"]);
                                            //die();

                                            $bol = $AirWayBill;


                                            //FOR STATUS OF EACH BOL
                                            $BLMsg = array();


                                            $ArrResult = ReadXMLFileBOL($bol);

                                            $BOLS = $ArrResult[0];
                                            $AWBXMLErr = $ArrResult[1];


                                            //====DISTRIBUTE ALL FROM ARRAY KEYS TO SPECIFIC VARIABLE NAME=======
                                            foreach ($BOLS as $key => $values) {
                                                ${"$key"} = $values;
                                            }
                                            //===================================================================


                                            //PUSH ERROR TO ARR
                                            if (count($AWBXMLErr) > 0) {

                                                //print_r($AWBXMLErr);
                                                //die();


                                                array_push($BLMsg, $AWBReference, "XML - Missing Information", $AWBXMLErr, $Goods1);
                                                $ManAdditionalErr = 1;


                                            } elseif (count($AWBXMLErr) == 0) {
                                                //****************************************************
                                                $Port = $EManCCNFunc->getManifestGenPort($ApplNo, $RegNo);
                                                $BLCustoms_office_segment = ($BLCustoms_office_segment) ? $BLCustoms_office_segment : $Port[0]['BOCOFC'];

                                                if ($EManCCNFunc->checkifDuplicateBOL($AWBReference, $BLCustoms_office_segment, $RegNo)) {
                                                    //echo "duplicate";

                                                    array_push($BLMsg, $AWBReference, "Duplicate Entry", $Goods1);
                                                    $ManAdditionalErr = 1;


                                                } else {

                                                    array_push($BLMsg, $AWBReference, "SUCCESS", $Goods1, $AWB_Nature, $CName);

                                                    $response = $EManCCNFunc->ManifestBOL($ApplNo, $RegNo, $BLCustoms_office_segment, $status, $Line_number, $AWBReference, $BLStatus, $AWBType, $AWB_Nature, $Unique_carrier_reference, $SName, $SAddress1, $SAddress2, $SAddress3, $SAddress4, $CName, $CAddress1, $CAddress2, $CAddress3, $CAddress4, $NName, $NAddress1, $NAddress2, $NAddress3, $NAddress4, $Place_of_loading_segment, $Place_of_unloading_segment, $Package_type_code, $Number_of_packages, $Total_gross_mass_manifested, $Volume_in_cubic_meters, $Marking1, $Goods1, $FreightAmount, $Currency, $InsuranceAmount, $DefaultVal, $cltcode, $cdate, $LGoods, $userid, $FreightInd, $auto_upload_status);

                                                    echo $response;

                                                }
                                                //========================================END AWB INFO=============================================================================================
                                            }

                                            //INSERT NOW THE STATUS OF BOL
                                            array_push($BOLStatus, $BLMsg);

                                            $CountBOL = 1;

                                            //========================================END AWB INFO=============================================================================================


                                            //END SINGLE BL===================================================================================================================

                                        }


                                        //print_r($BOLStatus);
                                        //die();

                                        if (!CountBOL($Total_number_of_mawb, $CountBOL)) {
                                            //Missing BOL
                                            array_push($BOLErr, ($Total_number_of_mawb - $CountBOL) . " BOL(s) - Missing.");
                                            $ManAdditionalErr = 1;
                                        }


                                    }


                                    //=========================END READING===============================================================================


                                    //--------------------SEND SUCCESS EMAIL----------------------

                                    if (!SendSuccessNotficationGen($EManCCNFunc, $file, $emailadd, $RegNo, $ApplNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival, $Total_number_of_mawb, $BOLStatus, $BOLErr, $ManifestStatus, $ManAdditionalErr, $FlightNo)) {
                                        echo "Failed to send email\n";
                                    }

                                    //NOW MOVE IT TO OLD FOLDER
                                    $NewfileName = "Manifest-Bol-Created-" . $ApplNo . "--" . $RegNo . "-" . $Customs_office_segment . "--" . $file;

                                    if ($ManAdditionalErr == 1) {

                                        $txt = SuccessWErrLogGen($RegNo, $ApplNo, $Customs_office_segment, $Date_of_arrival, $Time_of_arrival, $Total_number_of_mawb, $BOLStatus, $BOLErr, $ManifestStatus);

                                        if (!MoveFileXMLGEN($helper, $currentDirectory, $file, $errDir, $newDIR, $NewfileName, $txt)) {
                                            echo "Failed to move file\n";


                                        }
                                    } else {

                                        if (!MoveXMLFileGenSuccess($helper, $currentDirectory, $oldDir, $newDIR, $file, $NewfileName)) {
                                            echo "Failed to move file\n";
                                        }
                                    }


                                } //END CONTINUE READING


                            }
                        }
                    }
                }
            }
        }
    }
} else {
    die("Invalid folder location");
}
?>