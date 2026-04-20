<?php 
date_default_timezone_set("Asia/Kolkata");
//error_reporting(0);
ob_start();
session_start();
require("../model/config.inc.php");
require("../model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$user_id = $_SESSION['sess_user_id'] ?? '';
$user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$staff_id = $_SESSION['sess_staff_id'] ?? '';
$ipaddress = $_SESSION['sess_ipaddress'] ?? '';

$cur_date=date("Y-m-d");

$output_dir = "../fab_sup_upload_file/";

if(isset($_FILES["myfile"]))
{
	$update_id = $_GET['update_id'] ?? '';
	$expense_no = $_GET['expense_no'] ?? '';
	
	$random_no = $_GET['random_no'] ?? '';
	$random_sc = $_GET['random_sc'] ?? '';
	$doc_name = $_POST['doc_name'] ?? '';
	$description = $_POST['description'] ?? '';

	$ret = [];

	$error = $_FILES["myfile"]["error"] ?? 0;
	{
    	if(!is_array($_FILES["myfile"]['name'])) //single file
    	{
        	$RandomNum   = time();

            $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
            $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.

			$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.','',$ImageExt);
           	$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $RandomNum.'.'.$ImageExt;

       	 	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $NewImageName);
			

			$data = [
				'entry_date' => $cur_date,
				'fab_sup_id' => $update_id,
				'expense_no' => $expense_no,
				'file_name' => $NewImageName,
				'doc_name' => $doc_name,
				'description' => $description,
				'random_no' => $random_no,
				'random_sc' => $random_sc
			];
			$db->query_insert("daily_expense_image", $data);
			$ret[$NewImageName] = $output_dir.$NewImageName;
    	}
    	else
    	{
        	$fileCount = count($_FILES["myfile"]['name']);
    		for($i=0; $i < $fileCount; $i++)
    		{
            	$RandomNum   = time();

                $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name'][$i]));
                $ImageType      = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.

                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt);
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $RandomNum.'.'.$ImageExt;

                $ret[$NewImageName] = $output_dir.$NewImageName;
    		    move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$NewImageName );


				$data = [
					'entry_date' => $cur_date,
					'fab_sup_id' => $update_id,
					'expense_no' => $random_no,
					'file_name' => $NewImageName,
					'doc_name' => $doc_name,
					'description' => $description
				];
				$db->query_insert("daily_expense_image", $data);
			}
    	}
    }
    echo json_encode($ret);
}


if(isset($_POST['action']) && $_POST['action']=='update_document')
{
	$update_id_post = $_POST['update_id'] ?? '';
	$random_no_post = $_POST['random_no'] ?? '';
	$random_sc_post = $_POST['random_sc'] ?? '';
	$doc_name = $_POST['doc_name'] ?? '';
	$description = $_POST['description'] ?? '';
	
	$data = [
		'doc_name' => $doc_name,
		'description' => $description
	];
	$where = "fab_sup_id='".$db->escape($update_id_post)."' and random_no='".$db->escape($random_no_post)."' and random_sc='".$db->escape($random_sc_post)."'";
	$db->query_update("daily_expense_image", $data, $where);
}

if(isset($_POST['action']) && $_POST['action']=='file_upload_delete')
{
	$image_id = $_POST['image_id'] ?? '';
	$update_id = $_POST['update_id'] ?? '';

	$db->query_delete("daily_expense_image", "fab_sup_update_id='".$db->escape($image_id)."'");
	$file = $_POST['file_name'] ?? '';
	if($file) {
		unlink ('../fab_sup_upload_file/'.$file);
	}
}?>