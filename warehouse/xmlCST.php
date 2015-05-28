<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>寄倉入庫回覆檔(CST)</title>
<style type="text/css">
    table, tr, td{
        border: 1px solid black;
    }
</style>
</head>

<body>
	<h1>寄倉入庫回覆檔-CC_MON_CST_YYYYMMDDHH.xml</h1>
	<form action="../input.php" method="post">
        <?php
            date_default_timezone_set("Asia/Taipei");
            $date = date('Y/m/d');
            $dateString = date('YmdH');
        ?>
        <button>送出</button>
        <table id="cstItems">
		    <tbody>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="13">
			            文件編碼 <select id="EncodingSel" name="Encoding">
			                <option value="big5">big5(南崁倉/東源倉預設)</option>
		                    <option value="utf-8">utf-8(大園倉預設)</option></select>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="13">RECEIPRTDETAIL</td>
		        </tr>
		        <?php
		            for($i = 1; $i <= 10; $i ++) {
		                echo '
                            <tr>
                            <td><input name="CST[]" type="checkbox" value="'.$i.'"></td>
            			    <td>EXTERNRECEIPTKEY(進倉單編號SL) = <input name="EXTERNRECEIPTKEY'.$i.'" maxlength="16" size="19" type="text">
            			    <td>RECEIPTDATE(實際進倉日) = <input name="RECEIPTDATE'.$i.'" maxlength="12" size="14" type="text" value="'.$date.'"></td>
                            <td>SKU(product_id) = <input name="SKU'.$i.'" maxlength="8" size="10" type="text"></td>
            			    <td>DESCR(商品名稱) = <input name="DESCR'.$i.'" type="text"></td>
	    	                <td>NORMALQTY(良品數量) = <input name="NORMALQTY'.$i.'" maxlength="4" size="6" type="text"></td>
		                    <td>BADQTY(不良品數量) = <input name="BADQTY'.$i.'" maxlength="4" size="6" type="text"></td>
	    	                <td>CCLENGTH(商品長:cm) = <input name="CCLENGTH'.$i.'" maxlength="3" size="4" type="text"></td>
	    	                <td>CCWIDTH(商品寬:cm) = <input name="CCWIDTH'.$i.'" maxlength="3" size="4" type="text"></td>
	                        <td>CCHEIGHT(商品高:cm) = <input name="CCHEIGHT'.$i.'" maxlength="3" size="4" type="text"></td>
	                        <td>CCWEIGHT(商品重:g) = <input name="CCWEIGHT'.$i.'" maxlength="4" size="5" type="text"></td>
                            <td>BARCODE = <input name="BARCODE'.$i.'" maxlength="13" size="14" type="text"></td>
		                    <td>LIMIT_YN(是否有到期日) = <input name="LIMIT_YN'.$i.'" maxlength="1" size="2" type="text" value="N"></td>
			                <td>LIMIT_DEALINE(保存期限:天) = <input name="LIMIT_DEALINE'.$i.'" maxlength="4" size="5" type="text"></td>
                            </tr>                              
                        ';
		            }
		        ?>
		        <tr>
			       <td>&nbsp;</td>
			       <td colspan="13">The filename is <input id="FilenameId" name="Filename" maxlength="25" size="37" type="text" value="1_CC_MON_CST_<?php echo $dateString; ?>.xml"></td>
			    </tr>
	        </tbody>
		</table>
	</form>
</body>