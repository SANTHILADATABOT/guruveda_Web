<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(E_ALL);
ini_set("display_errors", 1);

/* -----------------------------------------
   FIX SESSION PERMISSION ISSUE (CYBERPANEL)
------------------------------------------ */
$custom_session_path = __DIR__ . "/../tmp_sessions";
if (!is_dir($custom_session_path)) {
    mkdir($custom_session_path, 0777, true);
}
ini_set("session.save_path", $custom_session_path);

session_start();

require("config.inc.php");
require("Database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

/* -----------------------------------------
   SAFE SESSION VARIABLES (NEVER EMPTY STRING)
------------------------------------------ */
$sess_user_type_id = (int) ($_SESSION['sess_user_type_id'] ?? 0);
$sess_user_id      = (int) ($_SESSION['sess_user_id'] ?? 0);
$sess_ipaddress    = $_SESSION['sess_ipaddress'] ?? $_SERVER['REMOTE_ADDR'];

$action = $_GET['action'] ?? '';

/* -----------------------------------------
   CREATE (SUBMIT)
------------------------------------------ */
if ($action == "SUBMIT") {

    $user_type = trim($_POST["user_type"] ?? "");
    $status    = $_POST["status"] ?? "0";

    if ($user_type == "") {
        echo "ERROR: EMPTY";
        exit;
    }

    // Duplicate check
    $sql = "
        SELECT user_type 
        FROM user_type 
        WHERE user_type = '".$db->escape($user_type)."'
        AND delete_status = 0
    ";
    $db->query($sql);

    if ($db->affected_rows > 0) {
        echo "EXIST";
        exit;
    }

    // Insert Data
    $data = [
        "user_type"         => $user_type,
        "status"            => (int)$status,
        "delete_status"     => 0,
        "sess_user_type_id" => $sess_user_type_id,
        "sess_user_id"      => $sess_user_id,
        "sess_ipaddress"    => $sess_ipaddress
    ];

    $insert_id = $db->query_insert("user_type", $data);

    echo $insert_id ? "OK" : "FAIL";
    exit;
}

/* -----------------------------------------
   UPDATE
------------------------------------------ */
if ($action == "UPDATE") {

    $update_id = (int) ($_POST["update_id"] ?? $_GET["update_id"] ?? 0);
    $user_type = trim($_POST["user_type"] ?? "");
    $status    = $_POST["status"] ?? "0";

    if ($update_id <= 0) {
        echo "ERROR: INVALID ID";
        exit;
    }

    if ($user_type == "") {
        echo "ERROR: EMPTY";
        exit;
    }

    // Duplicate check
    $sql = "
        SELECT user_type 
        FROM user_type 
        WHERE user_type = '".$db->escape($user_type)."'
        AND user_type_id != '".$db->escape($update_id)."'
        AND delete_status = 0
    ";
    $db->query($sql);

    if ($db->affected_rows > 0) {
        echo "EXIST";
        exit;
    }

    // Update Data
    $data = [
        "user_type"         => $user_type,
        "status"            => (int)$status,
        "sess_user_type_id" => $sess_user_type_id,
        "sess_user_id"      => $sess_user_id,
        "sess_ipaddress"    => $sess_ipaddress
    ];

    $db->query_update("user_type", $data, "user_type_id='" . $db->escape($update_id) . "'");
    echo "OK";
    exit;
}


/* -----------------------------------------
   DELETE (SOFT DELETE)
------------------------------------------ */
if ($action == "DELETE") {

    $delete_id = (int) ($_GET["delete_id"] ?? 0);

    $data = [
        "delete_status"     => 1,
        "sess_user_type_id" => $sess_user_type_id,
        "sess_user_id"      => $sess_user_id,
        "sess_ipaddress"    => $sess_ipaddress
    ];

    $db->query_update("user_type", $data, "user_type_id='" . $db->escape($delete_id) . "'");
    echo "OK";
    exit;
}

$db->close();
?>
