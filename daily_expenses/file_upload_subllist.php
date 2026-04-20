<?php
require_once("../model/config.inc.php"); 
require_once("../model/Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

$update_id = $_GET['update_id'] ?? '';
$expense_no = $_GET['expense_no'] ?? '';
?>
<table width="90%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="5%" height="35" align="left" class="text style5 style4 style1">&nbsp;<strong>#</strong></td>
        <td width="41%" class="text style5 style4 style1">&nbsp;<strong>File URL</strong></td>
          <td width="23%" class="text style5 style4 style1">&nbsp;<strong>Doc Name</strong></td>
        <td width="13%" class="text style5 style4 style1">&nbsp;<strong>File TYPE</strong></td>
        <td width="8%" class="text style5 style4 style1">&nbsp;<strong> View</strong></td>
        <td width="10%" align="center" class="text style5 style4 style1 style3">&nbsp;<strong>Action</strong>&nbsp;</td>
    </tr>
	<?php
	$sql = "select * from  daily_expense_image where expense_no='".$db->escape($expense_no)."' and fab_sup_id='".$db->escape($update_id)."'";
	$rs = $db->query($sql);
	$sno=0;
	if($rs && $rs instanceof mysqli_result) {
		while($rsdata = $db->fetch_array($rs))
		{
			if($rsdata) {
				$sno=$sno+1;
				$image_id = $rsdata['fab_sup_update_id'] ?? '';
				$file_name = $rsdata['file_name'] ?? '';
				$ex=explode(".",$file_name);
				$ext = $ex[1] ?? '';
				if($ext=="pdf"){ $src="../img/pdf_icon.png"; }
				else if($ext=="xlsx"){ $src="../img/excel-icon.png"; }
				else{ $src="../fab_sup_upload_file/$file_name"; }
				?>
				<tr>
					<td height="43" class="text style5  style4">&nbsp;<?php echo $sno; ?></td>
					<td class="text style5 style4 ">&nbsp;<img src="<?php echo htmlspecialchars($src, ENT_QUOTES); ?>" width="30px;" height="30px;"><?php echo htmlspecialchars($file_name, ENT_QUOTES); ?></td>
	                <td class="text style5 style4 ">&nbsp;<?php echo htmlspecialchars($rsdata['doc_name'] ?? '', ENT_QUOTES); ?></td>
					<td class="text style5 style4 ">&nbsp;<?php echo htmlspecialchars($ext, ENT_QUOTES); ?></td>
	                <td class="text style5 style4 " align="center">&nbsp;<img src="../img/views.png" style="width:22px;height:22px;" onclick="javascript:sample_image_popup('sample_image_popup.php?&sample_image=<?php echo htmlspecialchars($file_name, ENT_QUOTES); ?>')"/></td>
					<td align="center" class="text style5 style4 style3">&nbsp;<a href="#" onClick="fab_sup_file_upload_delete('<?php echo htmlspecialchars($image_id, ENT_QUOTES);?>')"><img src="../img/delete.jpg" alt="delete" title="DELETE" border="0" width="25px;" height="25px;" /></a></td>
				</tr>
				<?php
			}
		}
	}?>
</table>
<script>
function sample_image_popup(url)
{
	onmouseover= window.open(url,'onmouseover','height=480,width=750,scrollbars=yes,resizable=no,left=400,top=100,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
</script>