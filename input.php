<?php
$filename = $_POST["Filename"];
$encoding = $_POST["Encoding"];
$pattern = '/(\d+)\.(\w+)$/';
preg_match($pattern, $filename, $matches); // $matches[2] = extension file name (EX. EIN/SRP/PPS)

$xmlWriter = new XMLWriter();
$xmlWriter->openMemory();
if($encoding == 'big5') {
    $xmlWriter->startDocument('1.0', $encoding, 'yes');    
}
else{
    $xmlWriter->startDocument('1.0', $encoding);
}
$xmlWriter->setIndent(true);

if($matches[2] == "xml") {
    if(preg_match('/SHP/', $filename)) {
        $xmlWriter->startElement('orderstatus');
        $xmlWriter->writeElement('orderscnt', sizeof($_POST["Order"]));
        foreach($_POST["Order"] as $orderNo) {
            if(isset($orderNo)) {
                $xmlWriter->startElement('order');
                $xmlWriter->writeElement('orderid',  $_POST["orderid".$orderNo]);
                $xmlWriter->writeElement('carriageid', $_POST["carriageid".$orderNo] );
                foreach($_POST["Orderitem".$orderNo] as $orderitemNo) {
                    if(isset($orderitemNo)) {
                        $xmlWriter->startElement('orderitem');
                        $xmlWriter->writeElement('processid', $_POST["processid".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('deliveryno', $_POST["deliveryno".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('carton', $_POST["carton".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('actexportdatetime', $_POST["actexportdatetime".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('status', $_POST["status".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('rmid', $_POST["rmid".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('exportdatetime', $_POST["exportdatetime".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->writeElement('batchnumber', $_POST["batchnumber".$orderNo.'-'.$orderitemNo]);
                        $xmlWriter->endElement(); // for orderitem
                    }
                }
                $xmlWriter->endElement(); // for order
            }
        }
        $xmlWriter->endElement(); // for orderstatus
        $xmlWriter->endDocument();
    }
    elseif(preg_match('/CST/', $filename)) {
        $xmlWriter->startElement('RECEIPT');
        foreach($_POST["CST"] as $cst) {
            if(isset($cst)) {
                $xmlWriter->startElement('RECEIPTDETAIL');
                $xmlWriter->writeElement('TYPE', '0');
                $xmlWriter->writeElement('EXTERNRECEIPTKEY', $_POST["EXTERNRECEIPTKEY".$cst]);
                $xmlWriter->writeElement('RECEIPTDATE', $_POST["RECEIPTDATE".$cst]);
                $xmlWriter->writeElement('RECEIPTKEY', '');
                $xmlWriter->writeElement('SKU', $_POST["SKU".$cst]);
                $xmlWriter->startElement('DESCR');
                $xmlWriter->writeCData($_POST["DESCR".$cst]);
                $xmlWriter->endElement(); // for DESCR
                $xmlWriter->writeElement('NORMALQTY', $_POST["NORMALQTY".$cst]);
                $xmlWriter->writeElement('BADQTY', $_POST["BADQTY".$cst]);
                $xmlWriter->writeElement('CCLENGTH', $_POST["CCLENGTH".$cst]);
                $xmlWriter->writeElement('CCWIDTH', $_POST["CCWIDTH".$cst]);
                $xmlWriter->writeElement('CCHEIGHT', $_POST["CCHEIGHT".$cst]);
                $xmlWriter->writeElement('CCWEIGHT', $_POST["CCWEIGHT".$cst]);
                $xmlWriter->writeElement('BARCODE', $_POST["BARCODE".$cst]);
                $xmlWriter->writeElement('LIMIT_YN', $_POST["LIMIT_YN".$cst]);
                $xmlWriter->writeElement('LIMIT_DEALINE', $_POST["LIMIT_DEALINE".$cst]);
                $xmlWriter->endElement(); // for RECEIPTDETAIL
            }
        } 
        $xmlWriter->endElement(); // for RECEIPT
    }
}
elseif($matches[2] == "SRP") {
    $totalCount = $_POST["TotalCount"];
    $xmlWriter->text($totalCount."\n"); // Total orders' count
    $failedCount = sizeof($_POST["SRP"]);
    $successCount = $totalCount - $failedCount;
    $xmlWriter->text($successCount."\n"); // Successful orders' count
    $xmlWriter->text($failedCount."\n"); // Failed orders' count
    foreach($_POST["SRP"] as $srp) {
        if(isset($srp)) {
            $stringLine = $_POST["EshopId".$srp].$_POST["ShipmentNo".$srp].$_POST["Date".$srp].$_POST["StCode".$srp].str_pad($_POST["Amount".$srp], 5, '0', STR_PAD_LEFT).'Y'.str_pad("12345678", 30, " ", STR_PAD_LEFT).$_POST["SRPCode".$srp];
            $xmlWriter->text($stringLine."\n");
        }
    }
}
elseif($matches[2] == "EIN") {
    $xmlWriter->startElement('DCReceiveDoc');
    $xmlWriter->startElement('DocHead');
    $xmlWriter->writeElement('DocNo', $_POST["DocNo"]);
    $xmlWriter->writeElement('DocDate', $_POST["DocDate"]);
    $xmlWriter->startElement('From');
    $xmlWriter->writeElement('FromPartnerCode', $_POST["FromPartnerCode"]);
    $xmlWriter->endElement(); // for From
    $xmlWriter->startElement('To');
    $xmlWriter->writeElement('ToPartnerCode', $_POST["ToPartnerCode"]);
    $xmlWriter->endElement(); // for To
    $xmlWriter->writeElement('DocCount', sizeof($_POST["DCReceive"]));
    $xmlWriter->endElement(); // for DocHead
    $xmlWriter->startElement('DocContent');
    foreach($_POST["DCReceive"] as $orderNo) {
        if(isset($orderNo)) {
            $xmlWriter->startElement('DCReceive');
            $xmlWriter->writeElement('ParentId', $_POST["ParentId".$orderNo]);
            $xmlWriter->writeElement('EshopId', $_POST["EshopId".$orderNo]);
            $xmlWriter->writeElement('ShipmentNo', $_POST["ShipmentNo".$orderNo]);
            $xmlWriter->writeElement('DCReceiveDate', $_POST["DCReceiveDate".$orderNo]);
            $xmlWriter->writeElement('DCReceiveStatus', $_POST["DCReceiveStatus".$orderNo]);
            $DCRecName = "未設定";
            switch ($_POST["DCReceiveStatus".$orderNo]) {
                case 09:
                    $DCRecName = "未到貨";
                    break;
                case 39:
                    $DCRecName = "條碼資料錯誤";
                    break;
                case 99:
                    $DCRecName = "不正常到貨";
                    break;
                default:
                    $DCRecName = "進驗成功";
            }
            $xmlWriter->writeElement('DCRecName', $DCRecName);
            $xmlWriter->endElement(); // for DCReceive
        }
    }
    $xmlWriter->endElement(); // for DocContent
    $xmlWriter->endElement(); // for DCReceiveDoc
    $xmlWriter->endDocument();
}
elseif($matches[2] == "PPS") {
    $xmlWriter->startElement('PPSDoc');
    $xmlWriter->startElement('DocHead');
    $xmlWriter->writeElement('DocNo', $_POST["DocNo"]);
    $xmlWriter->writeElement('DocDate', $_POST["DocDate"]);
    $xmlWriter->startElement('From');
    $xmlWriter->writeElement('FromPartnerCode', $_POST["FromPartnerCode"]);
    $xmlWriter->endElement(); // for From
    $xmlWriter->startElement('To');
    $xmlWriter->writeElement('ToPartnerCode', $_POST["ToPartnerCode"]);
    $xmlWriter->endElement(); // for To
    $xmlWriter->writeElement('DocCount', sizeof($_POST["PPS"]));
    $xmlWriter->endElement(); // for DocHead
    $xmlWriter->startElement('DocContent');
    foreach($_POST["PPS"] as $pps) {
        if(isset($pps)) {
            $xmlWriter->startElement('PPS');
            $xmlWriter->writeElement('ParentId', $_POST["ParentId".$pps]);
            $xmlWriter->writeElement('EshopId', $_POST["EshopId".$pps]);
            $xmlWriter->writeElement('ShipmentNo', $_POST["ShipmentNo".$pps]);
            $xmlWriter->writeElement('StoreID', $_POST["StCode".$pps]);
            $xmlWriter->writeElement('StoreDate', $_POST["StoreDate".$pps]);
            $xmlWriter->writeElement('StoreTime', $_POST["StoreTime".$pps]);
            $xmlWriter->writeElement('StoreType', $_POST["StoreType".$pps]);
            $xmlWriter->writeElement('TelNo', '');
            $xmlWriter->endElement(); // for PPS
        }
    }
    $xmlWriter->endElement(); // for DocContent
    $xmlWriter->endElement(); // for PPSDoc
    $xmlWriter->endDocument();
}
else{
    //echo "We don't support this extension now: ".$matches[2];
}

// Save the file to local
header("Content-type: text/plain; charset=".$encoding);
header("Content-Disposition: attachment; filename=".$filename);
print $xmlWriter->outputMemory(true);
?>