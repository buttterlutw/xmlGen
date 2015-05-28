<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>門市到店檔(PPS)</title>
<style type="text/css">
    table, tr, td{
        border: 1px solid black;
    }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
var now = new Date();
var year = now.getFullYear();
var month = now.getMonth() + 1;
if(month <= 9) {
	month = '0' + month;
}
var day = now.getDate();
if(day <= 9) {
	day = '0' + day;
}
$(document).ready(function(){
	var ParentId = "000";
	var EshopId = "aaa";
	$("select").change(function(){
	    if($("#StoreTypeSel").val() == "823") {
		    ParentId = "823";
		    EshopId = $("#SupplierIdSel").val();
		    $("#DocNo").val(ParentId+year+month+day);
		    $("#FilenameId").val(ParentId+year+month+day+"01.PPS");
	    } else{
	    	ParentId = "839";
	    	EshopId = $("#StoreTypeSel").val();
	    	$("#DocNo").val(ParentId+EshopId+year+month+day);
	    	$("#FilenameId").val(ParentId+EshopId+year+month+day+"01.PPS");
	    }
	    $(".ParentId").val(ParentId);
	    $(".EshopId").val(EshopId);
    });
});
</script>
</head>

<body>
	<h1>門市到店檔-999XXXyyyymmdd99.PPS</h1>
	<form action="input.php" method="post">
        <?php
            date_default_timezone_set("Asia/Taipei");
            $date = date('Y-m-d');
            $dateString = date('Ymd');
            $time = date('His');
		    $eshopcode = "823"; // 購物中心7-11直店配
		    $childid = "A53"; // 興奇雅虎測試(4866)
		    $stcode = "991182"; // 馥樺門市
        ?>
        <button>送出</button>
        <table id="ppsItems">
		    <tbody>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="7">
			            文件編碼 <select id="EncodingSel" name="Encoding">
			                <option value="big5">big5(PPS預設值)</option>
		                    <option value="utf-8">utf-8</option></select>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="7">
			            超商類型 <select id="StoreTypeSel" name="StoreType">
			                <option value="823">7-11(823)</option>
		                    <option value="001">7-11(839001)(南崁)</option>
                            <option value="002">7-11(839002)(大園)</option></select>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="7">
			            供應商 <select id="SupplierIdSel" name="SupplierId">
			                <option value="A53">興奇雅虎測試(4866)</option>
		                    <option value="A14">興奇倉庫(551)</option></select>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="7">DocHead</td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td>DocNo = <input id="DocNo" name="DocNo" type="text" value="823<?php echo $dateString; ?>01"></td>
			        <td>DocDate = <input name="DocDate" type="text" value="<?php echo $date; ?>"></td>
			        <td>FromPartnerCode = <input name="FromPartnerCode" type="text" value="000"></td>
			        <td colspan="4" rowspan="1">ToPartnerCode = <input name="ToPartnerCode" type="text" value="999"></td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="7">DocContent/PPS</td>
		        </tr>
		        <?php
		            for($i = 1; $i <= 10; $i ++) {
		                echo '
                            <tr>
                            <td><input name="PPS[]" type="checkbox" value="'.$i.'"></td>
            			    <td>ParentId = <input name="ParentId'.$i.'" class="ParentId" maxlength="3" size="5" type="text" value="'.$eshopcode.'"></td>
            			    <td>EshopId = <input name="EshopId'.$i.'" class="EshopId" maxlength="3" size="5" type="text" value="'.$childid.'">
            			    <td>ShipmentNo = <input name="ShipmentNo'.$i.'" maxlength="8" size="12" type="text"></td>
                            <td>StoreId(馥樺門市:991182) = <input name="StCode'.$i.'" maxlength="6" size="12" type="text" value="'.$stcode.'"></td>
            			    <td>StoreDate = <input name="StoreDate'.$i.'" type="text" value="'.$date.'"></td>
	    	                <td>StoreTime(HHMMSS) = <input name="StoreTime'.$i.'" maxlength="6" size="12" type="text" value="'.$time.'"></td>
            			    <td>
		                        StoreType = <select name="StoreType'.$i.'">
		                            <option value="101">(101)門市配達</option>
		                            <option value="102">(102)EC 管制品配達</option></select>
		                    </td>
                            </tr>                              
                        ';
		            }
		        ?>
		        <tr>
			       <td>&nbsp;</td>
			       <td colspan="7">The filename is <input size="28" id="FilenameId" name="Filename" type="text" value="823<?php echo $dateString; ?>01.PPS"></td>
			    </tr>
	        </tbody>
		</table>
	</form>
</body>