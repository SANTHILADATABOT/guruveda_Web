<?php
error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once(__DIR__ . "/../model/config.inc.php");
require_once(__DIR__ . "/../model/Database.class.php");
require_once(__DIR__ . "/../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

if (!$db->connect()) {
    die("DB Connection Failed");
}

/* ===================== SAFE UPDATE ID ===================== */
$update_id = isset($_GET['update_id']) ? (int)$_GET['update_id'] : 0;

if ($update_id <= 0) {
    die("Invalid Update ID");
}

/* ===================== FETCH USER RECORD ===================== */
$sql  = "SELECT * FROM user_creation WHERE user_id = '" . $db->escape($update_id) . "'";
$rows = $db->fetch_all_array($sql);

if (empty($rows)) {
    die("Record not found for ID: " . $update_id);
}

$record = $rows[0];

/* ===================== SAFE VARIABLE SETUP ===================== */
$user_type        = $record['user_type_id'] ?? '';
$staff_id         = $record['staff_id'] ?? '';
$staff_name       = $record['staff_name'] ?? '';
$user_name        = $record['user_name'] ?? '';
$password         = isset($record['password']) ? base64_decode($record['password']) : '';
$confirm_password = isset($record['confirm_password']) ? base64_decode($record['confirm_password']) : '';
$user_status      = $record['user_status'] ?? '';
?>


<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Creation<small> Update</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Admin</a></li>
                    <li class="active">User Creation</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_creation/admin">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-toggle-left"></i> Back
            </button>
        </a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">

                        <form name="user_creation_form" id="user_creation_form">

                            <!-- =================== USER TYPE & STAFF =================== -->
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="form-control-label">User Type <span class="star">*</span></label>
                                    <select name="user_type" id="user_type" class="form-control" onChange="get_user_name(this.value)">
                                        <option value="">Select</option>
                                        <?php 
                                        $sql = "SELECT * FROM user_type WHERE delete_status!='1' ORDER BY user_type ASC";
                                        $rows = $db->fetch_all_array($sql);

                                        foreach($rows as $fetch_sql) {
                                            $utid = $fetch_sql['user_type_id'] ?? '';
                                        ?>
                                            <option value="<?php echo htmlspecialchars($utid, ENT_QUOTES); ?>" 
                                                <?php if($user_type == $utid) echo "selected"; ?>>
                                                <?php echo htmlspecialchars($fetch_sql['user_type'] ?? '', ENT_QUOTES); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col col-md-4">
                                    <label class="form-control-label">Staff Name <span class="star">*</span></label>
                                    <div id="staff_name_creation_div">
                                        <input type="text" id="staff_name" name="staff_name" class="form-control" 
                                               value="<?php echo htmlspecialchars($staff_name, ENT_QUOTES); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- =================== USERNAME & PASSWORD =================== -->
                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label class="form-control-label">User Name <span class="star">*</span></label>
                                    <input type="text" id="user_name" name="user_name" class="form-control"
                                           value="<?php echo htmlspecialchars($user_name, ENT_QUOTES); ?>">
                                </div>

                                <div class="col col-md-4">
                                    <label class="form-control-label">Password <span class="star">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control"
                                           value="<?php echo htmlspecialchars($password, ENT_QUOTES); ?>">
                                </div>

                                <div class="col col-md-4">
                                    <label class="form-control-label">Confirm Password <span class="star">*</span></label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                                           value="<?php echo htmlspecialchars($confirm_password, ENT_QUOTES); ?>">
                                </div>
                            </div>

                            <!-- =================== STATUS =================== -->
                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label class="form-control-label">Status</label>
                                    <select name="user_status" id="user_status" class="form-control">
                                        <option value="1" <?php if($user_status == '1') echo "selected"; ?>>Active</option>
                                        <option value="0" <?php if($user_status == '0') echo "selected"; ?>>InActive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- =================== BUTTONS =================== -->
                            <div class="card-footer">
                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        onClick="user_creation_update(
                                            user_type.value,
                                            staff_name.value,
                                            user_name.value,
                                            password.value,
                                            confirm_password.value,
                                            user_status.value,
                                            '<?php echo $update_id; ?>'
                                        )">
                                    <i class="fa fa-dot-circle-o"></i> Update
                                </button>

                                <a href="index1.php?filename=user_creation/admin" style="float:right;">
                                    <button type="button" class="btn btn-secondary btn-sm">Cancel</button>
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
