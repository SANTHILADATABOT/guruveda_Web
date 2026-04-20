<script>
function winprint(){
	window.print();
	//window.history.back();
}
//window.onload = function() { window.print(); }
</script>
<style type="text/css">
.style1 {font-weight:normal;font-family:calibri;font-size: 12px;}
.style2 {font-weight:normal;font-family:calibri;font-size: 14px;}
.style3 {font-weight:bold; text-align:right;font-family:calibri;font-size: 14px;}
.style4 {font-weight:bold; font-family:calibri;font-size: 14px;}
.style5 {font-family:calibri;font-weight: bold;font-size: 16px;}
.style6 {font-family:calibri;font-weight: bold;font-size: 18px;}
.top{ border-top: solid 1px; border-top-color:#BFBFBF;}
.bottom{ border-bottom: solid 1px; border-bottom-color:#BFBFBF;}
.style7 {font-weight:bold;font-family:Bookman Old Style;font-size: 12px;}
</style>
<?php 
error_reporting(0);
session_start();
require_once("../model/config.inc.php");
require_once("../model/Database.class.php");
require_once("../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();
$cur_date=date('Y-m-d');



$comp=$db->query_first("select * from company_details where id='1'");
?>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="850px" align="center">
    <tr>
        <td width="190" rowspan="2" align="center" class="style6"><?php if($comp[image_name]!='') {?><img src="../company_images/<?php echo $comp[image_name]; ?>" width="170" height="85"><?php }?></td>
    </tr>
    <tr>
        <td height="117" align="center" class="style7"><span style="font-size:32px;">
            <strong><?php echo $comp[company_name];?></strong></span><br>
            <sup><span style="font-size:14px;"><?php echo $comp[bill_name];?></span></sup><br>
            <?php echo $comp[address];?><br>
            <?php echo "Tel: ".$comp[phone_no].",".$comp[mobile_no]."&nbsp;&nbsp;&nbsp;Email: ".$comp[email_id];?><br>
          <span style="text-transform:uppercase; font-size:16px;"> <?php echo "GSTIN No:  ".$comp[gst_no];?></span>
        </td>
        <td height="117" valign="top" align="right" class="style7">Report on : <?php echo date('d-m-Y',strtotime(date('Y-m-d')));?>&nbsp;</td>
    </tr>
    <tr>
        <td height="19" valign="top" align="right" class="style2">&nbsp;</td>
        <td height="19" align="center" class="style7" style="font-size:14px;">SALES ORDER</td>
        <td height="19" valign="top" align="right" class="style2">&nbsp;</td>
    </tr>
</table>

<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="850px" align="center">

<?php
$sql = "select * from sales_order_main where salesorder_id='".$db->escape($_GET['salesorder_id'] ?? '')."' and random_sc='".$db->escape($_GET['random_sc'] ?? '')."' and random_no='".$db->escape($_GET['random_no'] ?? '')."' "; 
    $rows = $db->fetch_all_array($sql);
    foreach($rows as $record)
	{
		$salesorder_no = $record['salesorder_no'];
		$entry_date = $record['entry_date'];
		$sub_dealer_id = $record['sub_dealer_id'];
	}?>
    <tr>
        <td width="120" height="30" align="left" class="style2">Sales Order No</td>
        <td width="12">:</td>
		<td width="292" class="style2"><strong><?php echo $salesorder_no;?></strong></td>
        <td width="331" align="right" class="style2">Order Date</td>
		<td width="14" align="center">:</td>
		<td width="67" class="style2"><strong><?php echo  date("d-m-Y",strtotime($record['entry_date']));?></strong></td>
     </tr>
     <tr>   
        <td width="120"  height="30" align="left" class="style2">Dealer Name</td>
        <td>:</td>
		<td class="style2"><strong><?php echo  get_sub_dealer_name($sub_dealer_id);?></strong></td>
        
      </tr> 
  
    
</table>

<table width="850px" cellspacing="0" cellpadding="0" align="center" >
    <tr>
        <td width="86" height="30" align="left" class="top bottom style4"><strong>S.No</strong></td>
        <td width="288" align="left" class="top bottom style4"><strong>Item Name</strong></td>
        <td width="112" align="right" class="top bottom style4"><strong>Qty</strong></td>
        <td width="129" align="right" class="top bottom style4"><strong>Rate</strong></td>
        <td width="125" align="right" class="top bottom style4"><strong>Amount</strong>&nbsp;</td>
           
    </tr>
    <?php 
    $sql ="select * from sales_order_sublist where salesorder_no='".$db->escape($_GET['salesorder_no'] ?? '')."' and random_sc='".$db->escape($_GET['random_sc'] ?? '')."' and random_no='".$db->escape($_GET['random_no'] ?? '')."'  and delete_status!='1'";
    $rows = $db->fetch_all_array($sql);
	foreach($rows as $record)
		{
			?>
			<tr>
				<td align="left" height="25" class="style2"><?php echo $i = $i+1; ?>.</td>
				<td align="left" class="style2"><?php echo get_item_name($record['item_id']);?></td>
				<td align="right" class="style2"><?php echo $record['qty']; ?></td>
				<td align="right" class="style2"><?php echo number_format($record['rate'],2); ?></td>
				<td align="right" class="style2"><?php echo number_format($record['amount'],2);?>&nbsp;</td>
                
			</tr>
		   <?php
		   $total_total_amount+=$record['amount'];
		}?>
        
        <?php
$number =$total_total_amount;
$no = round($number);
$point = round($number - $no, 2) * 100;
$hundred = null;
$digits_1 = strlen($no);
$i = 0;
$str = array();
$words = array('0' => '', '1' => 'one', '2' => 'two',
'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
'7' => 'seven', '8' => 'eight', '9' => 'nine',
'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
'13' => 'thirteen', '14' => 'fourteen',
'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
'60' => 'sixty', '70' => 'seventy',
'80' => 'eighty', '90' => 'ninety');
$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
while ($i < $digits_1)
{
	$divider = ($i == 2) ? 10 : 100;
	$number = floor($no % $divider);
	$no = floor($no / $divider);
	$i += ($divider == 10) ? 1 : 2;
	if ($number)
	{
		$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
		$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
		$str [] = ($number < 21) ? $words[$number] .
		" " . $digits[$counter] . $plural . " " . $hundred
		:
		$words[floor($number / 10) * 10]
		. " " . $words[$number % 10] . " "
		. $digits[$counter] . $plural . " " . $hundred;
	}
	else $str[] = null;
}
$str = array_reverse($str);
$result = implode('', $str);
$points = ($point) ?
"." . $words[$point / 10] . " " . 
$words[$point = $point % 10] : '';
$result . "" . $points . " ";
?>
   
   <tr height="27">
			<td align="left" colspan="3" class="top style3 bottom"></td>
			<td width="108" align="right" class="top style3 bottom">Total&nbsp;</td>
			<td width="125" align="right" class="top style3 bottom"><?php echo number_format($total_total_amount,2);?>&nbsp;</td>
            
		</tr>
        
        <tr height="30">
        <td align="left" colspan="4" style="font-family:calibri;font-size: 14px;">Amount in words :
           <strong><?php echo ucfirst($result . " ". Only);?></strong></td>
        </tr>
  </table> 
  
  