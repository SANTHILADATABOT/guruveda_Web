<link href="../css/uploadfilemulti.css" rel="stylesheet">
<script src="../js/jquery/jquery-1.8.2.js"></script>
<script src="../bootstrap/js/jquery-1.12.3.js"></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script  src="../js/jquery/jquery.fileuploadmulti.min.js"></script>
<style type="text/css">
img {border-width: 0}
* {font-family:'Lucida Grande', sans-serif;}

.style1 {border-top: solid 1px;border-top-color: #A8A8A8;border-bottom: solid 1px;border-bottom-color: #A8A8A8;}
.style5 {border-left: solid 1px;border-left-color: #A8A8A8;}
.style3{ border-right: solid 1px;border-right-color: #A8A8A8; }
.style4 {border-bottom: solid 1px;border-bottom-color: #A8A8A8;}
.text{ font-family: Verdana; font-size:13px;}
</style>

<?php 
require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 
$update_id=$_GET['update_id'];
$expense_no=$_GET['expense_no'];
$date=date("Y");
$month=date("m");
$year=date("d");
$hour=date("h");
$minute=date("i");
$second=date("s");
$random_sc = date('dmyhis');
$random_no = rand(00000, 99999);
?>
<br><br>
<input type="hidden" name="random_no" id="random_no" value="<?php echo $random_no; ?>">
<input type="hidden" name="random_sc" id="random_sc" value="<?php echo $random_sc; ?>">
<div class="form-group">
    <div class="col-sm-1">
        <label><strong>Document Name</strong></label><br>
        <input type="text" class="form-control" name="doc_name" id="doc_name" style="width:300px;"/>
    </div>
    
</div>
<div class="form-group" style="margin-top: -79px; margin-left: 333px;">
    <div class="col-sm-1">
        <label><strong>Description</strong></label><br>
        <textarea class="form-control" name="description" id="description" style="width:300px;"></textarea>
    </div>
</div>
<b style="margin-left: 118px;">Multiple Files Upload:</b><br><br>
<div align="right" id="mulitplefileuploader" style="margin-left: 116px;">Browse</div>
<div id="status"></div>
<div></div>
<br><br>
<div align="center" style="margin-bottom: 10px;">
    <button type="button" name="submit" id="close_button" class="btn btn-danger btn-xls" onClick="close_pop()">Close</button>
</div>


<div id="fab_sup_file_upload_div" style="margin-left: 10px;">
	<?php include("file_upload_subllist.php"); ?>
</div>

<p>&nbsp;</p>
<p>&nbsp; </p>

<script>
$(document).ready(function()
{
	var doc_name=document.getElementById("doc_name").value;
	var description=document.getElementById("description").value;
	var random_no=document.getElementById("random_no").value;
	var random_sc=document.getElementById("random_sc").value;
	
	var settings = {
		url: "file_upload_db.php?update_id=<?php echo $update_id;?>&expense_no=<?php echo $expense_no;?>&random_no=<?php echo $random_no;?>&random_sc=<?php echo $random_sc;?>&doc_name="+doc_name+"&description="+description,	
		method: "POST",
		allowedTypes:"jpg,png,gif,zip,jpeg",
		fileName: "myfile",
		multiple: true,
		onSuccess:function(files,data,xhr)
		{
			var doc_name=document.getElementById("doc_name").value;
	var description=document.getElementById("description").value;
			alert(doc_name);
			jQuery.ajax({
				type: "POST",
				url: "file_upload_db.php",
				data: "update_id=<?php echo $update_id;?>&expense_no=<?php echo $expense_no;?>&random_no=<?php echo $random_no;?>&random_sc=<?php echo $random_sc;?>&action=update_document"+"&doc_name="+doc_name+"&description="+description,
				success: function(msg){
					$("#status").html("<font color='green'>Uploaded Successfully</font>");
					window.location.reload(true);
					alert("Uploaded Successfully");
					window.location.href = 'fab_sup_file_upload.php?update_id=<?php echo $update_id;?>&expense_no=<?php echo $expense_no;?>'
				},
			});
		},
    	afterUploadAll:function()
    	{
    	},
		onError: function(files,status,errMsg)
		{		
			$("#status").html("<font color='red'>Upload is Failed</font>");
			alert("Upload is Failed");
	      	window.location.reload(true);
		}
	}
	$("#mulitplefileuploader").uploadFile(settings);
});

function fab_sup_file_upload_delete(image_id,update_id,customer_no,file_name)
{
	alert(image_id);
	
	if(confirm('Are You Sure! You Want To Delete?'))
	{
		jQuery.ajax({
			type: "POST",
			url: "file_upload_db.php",
			data: "image_id="+image_id+"&update_id="+update_id+"&customer_no="+customer_no+"&file_name="+file_name+"&action=file_upload_delete",
			success: function(msg){
				jQuery("#fab_sup_file_upload_div").html(msg);
				window.location.reload(true);
			}
		});
    }
}

function close_pop()
{
	jQuery("#fab_sup_file_upload_div").html();
	window.close();
}

$(document).ready(function(){
	$("#close_button").click(function(){
		$("#purchase_file_upload_div1").html(ajax_load).load(loadUrl);
		window.close();
	});
});
</script>