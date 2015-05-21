<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>物流驗收檔(EIN)</title>
<style type="text/css">
    table{
        border: 1px solid black;
    }
    tr, td{
        border: 1px solid black;
    }
</style>
</head>

<body>
	<h1>物流驗收檔-999XXXyyyymmdd99.EIN</h1>
	<form action="input.php" method="post">
        <?php
            date_default_timezone_set("Asia/Taipei");
            $date = date('Y-m-d');
            $dateString = date('Ymd');
        ?>
        <button>送出</button>
        <table id="einItems">
		    <tbody>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="5">DocHead</td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td>DocNo = <input name="DocNo" type="text" value="839001<?php echo $dateString; ?>01"></td>
			        <td>DocDate = <input name="DocDate" type="text" value="<?php echo $date; ?>"></td>
			        <td>FromPartnerCode = <input name="FromPartnerCode" type="text" value="000"></td>
			        <td colspan="2" rowspan="1">ToPartnerCode = <input name="ToPartnerCode" type="text" value="999"></td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="5">DocContent/DCReceive</td>
		        </tr>
		        <?php
		            $eshopcode = "839";
		            $childid = "001";
		            for($i = 1; $i <= 10; $i ++) {
		                echo '
                            <tr>
                            <td><input name="DCReceive[]" type="checkbox" value="'.$i.'"></td>
            			    <td>ParentId = <input name="ParentId[]" type="text" value="'.$eshopcode.'"></td>
            			    <td>EshopId = <input name="EshopId[]" type="text" value="'.$childid.'"></td>
            			    <td>ShipmentNo = <input name="ShipmentNo[]" type="text"></td>
            			    <td>DCReceiveDate = <input name="DCReceiveDate[]" type="text" value="'.$date.'"></td>
            			    <td>
		                        DCReceiveStatus/DCRecName = <select name="DCReceiveStatusName[]">
		                            <option value="00">(00)進驗成功</option>
		                            <option value="09">(09)未到貨</option>
		                            <option value="39">(39)條碼資料錯誤</option>
		                            <option value="99">(99)不正常到貨</option>
		                    </td>
                            </tr>                              
                        ';
		            } 
		        ?>
	        </tbody>
		</table>
	</form>
</body>