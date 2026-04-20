<?php
date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

ob_start();
session_start();

require("config.inc.php");
require("Database.class.php");
require_once("../include/common_function.php");

// ✅ INIT DB (MYSQLI CLASS)
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

// ✅ SAFE SESSION DEFAULTS (INT FIELDS)
$sess_user_type_id = (isset($_SESSION['sess_user_type_id']) && is_numeric($_SESSION['sess_user_type_id'])) 
    ? (int)$_SESSION['sess_user_type_id'] : 0;

$sess_user_id = (isset($_SESSION['sess_user_id']) && is_numeric($_SESSION['sess_user_id'])) 
    ? (int)$_SESSION['sess_user_id'] : 0;

$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? 'UNKNOWN';

// ✅ STAFF NAME HANDLER
function get_user_creation_staff_name($user_type, $staff_id)
{
    if ($user_type == 2)      { return get_distributor_name($staff_id); }
    elseif ($user_type == 3) { return get_sales_ref_name($staff_id); }
    elseif ($user_type == 4) { return get_dealer_name($staff_id); }
    elseif ($user_type == 5) { return get_sub_dealer_name($staff_id); }
    else                     { return $staff_id; }
}

$action = $_GET['action'] ?? '';

switch ($action) {

    /* ========================== CREATE USER ========================== */
    case "SUBMIT":

        $user_type   = (int)($_POST['user_type'] ?? 0);
        $staff_id    = $db->escape($_POST['staff_name'] ?? '');
        $user_name   = $db->escape($_POST['user_name'] ?? '');
        $user_status = (int)($_POST['user_status'] ?? 1);

        if ($user_type === 0 || $user_name === '') {
            echo "INVALID_INPUT";
            exit;
        }

        // ✅ DUPLICATE CHECK (MYSQLI STYLE)
        $check_sql = "
            SELECT user_id FROM user_creation
            WHERE user_type_id = '$user_type'
              AND user_name = '$user_name'
              AND delete_status != 1
        ";

        $check_result = $db->query($check_sql);

        if ($check_result && $db->affected_rows == 0) {

            $staff_name = get_user_creation_staff_name($user_type, $staff_id);

            // ⚠ Keep base64 because your system already uses it
            $password          = base64_encode($_POST['password'] ?? '');
            $confirm_password = base64_encode($_POST['confirm_password'] ?? '');

            // ✅ REQUIRED NOT NULL COLUMN
            $token_id = uniqid("USR_");

            $data = [
                'user_type_id'       => $user_type,
                'staff_id'           => $staff_id,
                'staff_name'         => $staff_name,
                'user_name'          => $user_name,
                'password'           => $password,
                'confirm_password'  => $confirm_password,
                'user_status'        => $user_status,
                'sess_user_type_id' => $sess_user_type_id, // ✅ INT
                'sess_user_id'      => $sess_user_id,      // ✅ INT
                'sess_ipaddress'    => $sess_ipaddress,
                'delete_status'     => 0,
                'token_id'          => $token_id,
                'apk_version'       => 'null'
            ];

            $insert_id = $db->query_insert("user_creation", $data);

            if ($insert_id) {
                echo "SUCCESS";
            } else {
                echo "INSERT_FAILED";
            }

        } else {
            echo "Already Exist";
        }

    break;


    /* ========================== UPDATE USER ========================== */
    case "UPDATE":

        $update_id = (int)($_GET['update_id'] ?? 0);

        if ($update_id === 0) {
            echo "INVALID_ID";
            exit;
        }

        $user_type  = (int)($_POST['user_type'] ?? 0);
        $staff_id   = $db->escape($_POST['staff_name'] ?? '');
        $user_name  = $db->escape($_POST['user_name'] ?? '');
        $status     = (int)($_POST['user_status'] ?? 1);

        $staff_name = get_user_creation_staff_name($user_type, $staff_id);

        $password          = base64_encode($_POST['password'] ?? '');
        $confirm_password = base64_encode($_POST['confirm_password'] ?? '');

        $data = [
            'user_type_id'       => $user_type,
            'staff_id'           => $staff_id,
            'staff_name'         => $staff_name,
            'user_name'          => $user_name,
            'password'           => $password,
            'confirm_password'  => $confirm_password,
            'user_status'        => $status,
            'sess_user_type_id' => $sess_user_type_id,
            'sess_user_id'      => $sess_user_id,
            'sess_ipaddress'    => $sess_ipaddress
        ];

        $db->query_update("user_creation", $data, "user_id = '$update_id'");
        echo "UPDATED";

    break;


    /* ========================== DELETE USER ========================== */
    case "DELETE":

        $delete_id = (int)($_GET['delete_id'] ?? 0);

        if ($delete_id === 0) {
            echo "INVALID_ID";
            exit;
        }

        $db->query_update("user_creation", ['delete_status' => 1], "user_id = '$delete_id'");
        echo "Successfully Deleted";

    break;


    /* ========================== STATUS UPDATE ========================== */
    case "STATUS":

        $user_id = (int)($_GET['user_id'] ?? 0);
        $status  = (int)($_GET['user_status'] ?? 0);

        if ($user_id === 0) {
            echo "INVALID_ID";
            exit;
        }

        $db->query_update("user_creation", ['user_status' => $status], "user_id = '$user_id'");
        echo "STATUS_UPDATED";

    break;
}

$db->close();
?>
