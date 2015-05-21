<?php
date_default_timezone_set ("Asia/Taipei");
$date = date ('YmdH');
$filename = "1_CC_MON_SHP_" . $date . ".xml";
$xmlShp = new XMLWriter();
$xmlShp->openMemory();
$xmlShp->startDocument('1.0','UTF-8');
$xmlShp->setIndent(true);
$xmlShp->startElement('orderstatus');
$xmlShp->writeElement('orderscnt', sizeof($_POST["Order"]));
foreach($_POST["Order"] as $orderNo) {
    if(isset($orderNo)) {
        $xmlShp->startElement('order');
        $xmlShp->writeElement('orderid',  $_POST["orderid".$orderNo]);
        $xmlShp->writeElement('carriageid', $_POST["carriageid".$orderNo] );
        foreach($_POST["Orderitem".$orderNo] as $orderitemNo) {
            if(isset($orderitemNo)) {
                $xmlShp->startElement('orderitem');
                $xmlShp->writeElement('processid', $_POST["processid".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('deliveryno', $_POST["deliveryno".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('carton', $_POST["carton".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('actexportdatetime', $_POST["actexportdatetime".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('status', $_POST["status".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('rmid', $_POST["rmid".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('exportdatetime', $_POST["exportdatetime".$orderNo.'-'.$orderitemNo]);
                $xmlShp->writeElement('batchnumber', $_POST["batchnumber".$orderNo.'-'.$orderitemNo]);
                $xmlShp->endElement(); // for orderitem
            }
        }
        $xmlShp->endElement(); // for order
    }
}
$xmlShp->endElement(); // for orderstatus
$xmlShp->endDocument();

// Save the file to local
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=".$filename);
print $xmlShp->outputMemory(true);
?>