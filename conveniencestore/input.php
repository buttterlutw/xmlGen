<?php
$filename = $_POST["Filename"];
$encoding = $_POST["Encoding"];
$xmlEIN = new XMLWriter();
$xmlEIN->openMemory();
$xmlEIN->startDocument('1.0',$encoding);
$xmlEIN->setIndent(true);
$xmlEIN->startElement('DCReceiveDoc');
$xmlEIN->startElement('DocHead');
$xmlEIN->writeElement('DocNo', $_POST["DocNo"]);
$xmlEIN->writeElement('DocDate', $_POST["DocDate"]);
$xmlEIN->startElement('From');
$xmlEIN->writeElement('FromPartnerCode', $_POST["FromPartnerCode"]);
$xmlEIN->endElement(); // for From
$xmlEIN->startElement('To');
$xmlEIN->writeElement('ToPartnerCode', $_POST["ToPartnerCode"]);
$xmlEIN->endElement(); // for To
$xmlEIN->writeElement('DocCount', sizeof($_POST["DCReceive"]));
$xmlEIN->endElement(); // for DocHead
$xmlEIN->startElement('DocContent');
foreach($_POST["DCReceive"] as $orderNo) {
    if(isset($orderNo)) {
        $xmlEIN->startElement('DCReceive');
        $xmlEIN->writeElement('ParentId', $_POST["ParentId".$orderNo]);
        $xmlEIN->writeElement('EshopId', $_POST["EshopId".$orderNo]);
        $xmlEIN->writeElement('ShipmentNo', $_POST["ShipmentNo".$orderNo]);
        $xmlEIN->writeElement('DCReceiveDate', $_POST["DCReceiveDate".$orderNo]);
        $xmlEIN->writeElement('DCReceiveStatus', $_POST["DCReceiveStatus".$orderNo]);
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
        $xmlEIN->writeElement('DCRecName', $DCRecName);
        $xmlEIN->endElement(); // for DCReceive
    }
}
$xmlEIN->endElement(); // for DocContent
$xmlEIN->endElement(); // for DCReceiveDoc
$xmlEIN->endDocument();

// Save the file to local
header("Content-type: text/plain; charset=".$encoding);
header("Content-Disposition: attachment; filename=".$filename);
print $xmlEIN->outputMemory(true);
?>