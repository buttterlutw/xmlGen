<?php
$filename = $_POST["Filename"];
$encoding = $_POST["Encoding"];

$pattern = '/(\d+)\.(\w+)$/';
preg_match($pattern, $filename, $matches); // $matches[2] = extension file name (EX. EIN/SRP/PPS)

$xmlWriter = new XMLWriter();
$xmlWriter->openMemory();
if($matches[2] == "SRP") {
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
    $xmlWriter->startDocument('1.0',$encoding);
    $xmlWriter->setIndent(true);
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
else{
    echo "We don't support this extension now: ".$matches[2];
}



// Save the file to local
header("Content-type: text/plain; charset=".$encoding);
header("Content-Disposition: attachment; filename=".$filename);
print $xmlWriter->outputMemory(true);
?>