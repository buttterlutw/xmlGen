<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出貨確認回覆檔(SHP)</title>
<style type="text/css">
    table{
        border: 1px solid black;
        width: 2300px;
    }
    tr, td{
        border: 1px solid black;
    }
</style>
</head>

<body>
	<h1>出貨確認回覆檔-CC_MON_SHP_YYYYMMDDHH.xml</h1>
	<form action="input.php" method="post">
        <?php
            date_default_timezone_set ( "Asia/Taipei" );
            $date = date ( 'Y-m-d H:i' );
        ?>
        <button>送出</button>
        <table id="shpItems">
		    <tbody>
		        <tr>
			        <td>&nbsp;</td>
			        <td>
			            Order Info <hr>
			            <p style="font-size: 15px">
			                orderid => <br> 
			                一起買序號(RG) <br>
                            carriageid => <br> 
                            物流服務費的process_id <br>
                            (沒有就填0) <br>
			            </p>
			        </td>
			        <td>&nbsp;</td>
			        <td>
			            Orderitem Info <hr>
			            <p style="font-size: 15px">
			                processid => 購物子單：14188553 <br>
                            deliveryno => 宅配單號：如果status=2失敗,就不會有宅配單號 <br>
                            carton => 裝箱規格：1 <br>
                            actexportdatetime => 實際出貨日期時間：2008-01-09 14:20 <br>
                            status => 狀態：1-出貨成功, 2-出貨失敗(缺貨取消), 3-出貨失敗, 4-出貨失敗(超材) <br>
                            rmid => 購物單號(RM) <br>
                            exportdatetime => 產生日期時間：2008-01-09 14:20 <br>
                            batchnumber => 商品出貨批號(stlend_id)：SL0712190000007 <br>
                        </p>
			        </td>
		        </tr>
		        <?php 
		            for ($i = 1; $i <= 10; $i ++) { // 預設10筆order
		                echo '<tr>
			                      <td colspan="1" rowspan="5"><input name="Order[]" type="checkbox" value="'.$i.'"></td>
                                  <td colspan="1" rowspan="5">
	                                  Order '.$i.' <br>
                                      orderid = <input name="orderid'.$i.'" type="text"> <br>
                                      carriageid = <input name="carriageid'.$i.'" type="text"> <br>
                                  </td>
			                      <td><input name="Orderitem'.$i.'[]" type="checkbox" value="1"></td>
			                      <td>
                                      Orderitem '.$i.'-1 <hr>
                                      processid = <input name="processid'.$i.'-1" type="text">
                                      deliveryno = <input name="deliveryno'.$i.'-1" type="text">
                                      carton = <input name="carton'.$i.'-1" type="text">
                                      actexportdatetime = <input name="actexportdatetime'.$i.'-1" type="text" value="'.$date.'">  
                                      status = <input name="status'.$i.'-1" type="text">  
                                      rmid = <input name="rmid'.$i.'-1" type="text">
                                      exportdatetime = <input name="exportdatetime'.$i.'-1" type="text" value="'.$date.'">
                                      batchnumber = <input name="batchnumber'.$i.'-1" type="text">
                                  </td>
		                      </tr>';
		                for ($j = 2; $j <= 5; $j ++) { // 預設每筆order有5筆orderitem
		                    echo '<tr>
		                              <td><input name="Orderitem'.$i.'[]" type="checkbox" value="'.$j.'"></td>
			                          <td>
                                          Orderitem '.$i.'-'.$j.' <hr>
                                          processid = <input name="processid'.$i.'-'.$j.'" type="text"> 
                                          deliveryno = <input name="deliveryno'.$i.'-'.$j.'" type="text">
                                          carton = <input name="carton'.$i.'-'.$j.'" type="text">
                                          actexportdatetime = <input name="actexportdatetime'.$i.'-'.$j.'" type="text" value="'.$date.'">
                                          status = <input name="status'.$i.'-'.$j.'" type="text">
                                          rmid = <input name="rmid'.$i.'-'.$j.'" type="text">
                                          exportdatetime = <input name="exportdatetime'.$i.'-'.$j.'" type="text" value="'.$date.'"> 
                                          batchnumber = <input name="batchnumber'.$i.'-'.$j.'" type="text">
                                      </td>
		                          </tr>';
		                }
		            }
		        ?> 
	        </tbody>
		</table>
		<button>送出</button>
	</form>
</body>