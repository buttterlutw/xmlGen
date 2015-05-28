<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出貨驗證檔(SRP)</title>
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
		    $("#FilenameId").val(ParentId+year+month+day+"01.SRP");
	    } else{
	    	ParentId = "839";
	    	EshopId = $("#StoreTypeSel").val();
	    	$("#FilenameId").val(ParentId+EshopId+year+month+day+"01.SRP");
	    }
	    $(".EshopId").val(EshopId);
    });
});
</script>
</head>

<body>
	<h1>出貨驗證檔-999XXXyyyymmdd99.SRP</h1>
	<form action="input.php" method="post">
        <?php
            date_default_timezone_set("Asia/Taipei");
            $date = date('Y-m-d');
            $dateString = date('Ymd');
		    $stcode = "991182"; // 馥樺門市
		    $childid = "A53"; // 興奇雅虎測試(4866)
        ?>
        <button>送出</button>
        <table id="einItems">
		    <tbody>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="6">
			            文件編碼 <select id="EncodingSel" name="Encoding">
			                <option value="big5">big5(SRP預設值)</option>
		                    <option value="utf-8">utf-8</option>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="6">
			            超商類型 <select id="StoreTypeSel" name="StoreType">
			                <option value="823">7-11(823)</option>
		                    <option value="001">7-11(839001)(南崁)</option>
                            <option value="002">7-11(839002)(大園)</option>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="6">
			            供應商 <select id="SupplierIdSel" name="SupplierId">
			                <option value="A53">興奇雅虎測試(4866)</option>
		                    <option value="A14">興奇倉庫(551)</option>
			        </td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="6">總筆數(大於本次回饋筆數就好) = <input name="TotalCount" type="text" value="100"></td>
		        </tr>
		        <tr>
		            <td>&nbsp;</td>
			        <td colspan="6">SRP Contents</td>
		        </tr>
		        <?php
		            for($i = 1; $i <= 10; $i ++) {
		                echo '
                            <tr>
                            <td><input name="SRP[]" type="checkbox" value="'.$i.'"></td>
            			    <td>子代碼 = <input name="EshopId'.$i.'" class="EshopId" maxlength="3" size="5" type="text" value="'.$childid.'"></td>
            			    <td>出貨單號(spst_shpno) = <input name="ShipmentNo'.$i.'" maxlength="8" size="12" type="text"></td>
            			    <td>日期(YYYYMMDD) = <input name="Date'.$i.'" maxlength="6" size="12" type="text" value="'.$dateString.'"></td>
            			    <td>門市代號(馥樺門市:991182) = <input name="StCode'.$i.'" maxlength="6" size="12" type="text" value="'.$stcode.'"></td>
		                    <td>出貨單金額 = <input name="Amount'.$i.'" maxlength="5" size="8" type="text"></td>
                            <td>
                                回覆訊息代碼 = <select name="SRPCode'.$i.'" class="SRPCode" type="text">
		                            <option value="01110">(01110)門市已關轉店</option>
		                            <option value="01109">(01109)出貨編號已存在</option>
                            </td>
                            </tr>                              
                        ';
		            }
		        ?>
		        <tr>
			       <td>&nbsp;</td>
			       <td colspan="6">The filename is <input size="28" id="FilenameId" name="Filename" type="text" value="823<?php echo $dateString; ?>01.SRP"></td>
			    </tr>
			    <tr>
			       <td>&nbsp;</td>
			       <td colspan="6"><a target="_blank" href="http://emap.pcsc.com.tw/emap.aspx">門市代碼線上查詢</a></td>
			    </tr>   
	        </tbody>
		</table>
	</form>
</body>