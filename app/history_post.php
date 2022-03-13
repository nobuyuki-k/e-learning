<?php
require_once("../libs/functions.php");
require_once("../libs/HistoryDAO.php");

$account_id = get_account_id();
if ($account_id === false)
{
    error_log("Not signed in.");
    header("Location: error.php");
    exit();
}

$csrf_token = (string)filter_input(INPUT_POST, "csrf_token");
if (validate_csrf_token($csrf_token) === false)
{
    error_log("Invalid csrf token.");
    header("Location: error.php");
    exit();
}

$course_id = (string)filter_input(INPUT_POST, "course_id");
if ($course_id === "")
{
    error_log("Validate: course_id is not required.");
    header("Location: error.php");
    exit();
}
if (filter_var($course_id, FILTER_VALIDATE_INT) === false)
{
    error_log("Validate: course_id is not int.");
    header("Location: error.php");
    exit();
}

$section_id = (string)filter_input(INPUT_POST, "section_id");
if ($section_id === "")
{
    error_log("Validate: section_id is not required.");
    header("Location: error.php");
    exit();
}
if (filter_var($section_id, FILTER_VALIDATE_INT) === false)
{
    error_log("Validate: section_id is not int.");
    header("Location: error.php");
    exit();
}

try {
    $pdo= new_PDO();

    $history_dao = new HistoryDAO($pdo);
    $history_dao->insert($account_id, $section_id);
    set_message(MESSAGE_FINISH_SECTION);
    header("Location: detail.php?course_id=$course_id&ection_id=$section_id");
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}