<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
require_once("../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

$user_type = $_GET['user_type'] ?? '';

if($user_type==2){?> 
	<select name="staff_name" id="staff_name" class="form-control" >
        <option value="">Select</option>
        <?php $sql = "SELECT * FROM distributor_creation where delete_status!='1' order by distributor_name ASC";
        $rows = $db->fetch_all_array($sql);
        foreach($rows as $row) {?>
            <option value="<?php echo htmlspecialchars($row['distributor_id'] ?? '', ENT_QUOTES);?>"><?php echo htmlspecialchars($row['distributor_name'] ?? '', ENT_QUOTES);?></option>
        <?php } ?>
	</select>
	<?php
}
elseif($user_type==3){?>
	<select name="staff_name" id="staff_name" class="form-control" >
        <option value="">Select</option>
        <?php $sql = "SELECT * FROM sales_ref_creation where delete_status!='1' order by sales_ref_name ASC";
        $rows = $db->fetch_all_array($sql);
        foreach($rows as $row) {?>
            <option value="<?php echo htmlspecialchars($row['sales_ref_id'] ?? '', ENT_QUOTES);?>"><?php echo htmlspecialchars($row['sales_ref_name'] ?? '', ENT_QUOTES);?></option>
        <?php } ?>
    </select>
<?php
}
elseif($user_type==4){?>
    <select name="staff_name" id="staff_name" class="form-control" >
        <option value="">Select</option>
        <?php $sql = "SELECT * FROM dealer_creation where delete_status!='1' order by dealer_name ASC";
        $rows = $db->fetch_all_array($sql);
        foreach($rows as $row) {?>
            <option value="<?php echo htmlspecialchars($row['dealer_id'] ?? '', ENT_QUOTES);?>"><?php echo htmlspecialchars($row['dealer_name'] ?? '', ENT_QUOTES);?></option>
        <?php } ?>
    </select>
<?php
}
elseif($user_type==5){?>
    <select name="staff_name" id="staff_name" class="form-control" >
        <option value="">Select</option>
        <?php $sql = "SELECT * FROM sub_dealer_creation where delete_status!='1' order by sub_dealer_name ASC";
        $rows = $db->fetch_all_array($sql);
        foreach($rows as $row) {?>
            <option value="<?php echo htmlspecialchars($row['sub_dealer_id'] ?? '', ENT_QUOTES);?>"><?php echo htmlspecialchars($row['sub_dealer_name'] ?? '', ENT_QUOTES);?></option>
        <?php } ?>
    </select>
<?php
}
else{?> 
	<input type="text" id="staff_name" name="staff_name" class="form-control">
	<?php
}?>