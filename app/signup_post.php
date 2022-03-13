<?php
require_once("../libs/functions.php");
require_once("../libs/AccountDAO.php");

$csrf_token = (string)filter_input(INPUT_POST, "csrf_token");
if (validate_csrf_token($csrf_token) === false)
{
    error_log("Invalid crsf token.");
    header("Location: error.php");
    exit();
}

$name = (string)filter_input(INPUT_POST, "name");
if ($name === "")
{
    set_message(MESSAGE_SIGNUP_ERROR);
    header("Location: signup.php");
    exit();
}
if (mb_strlen($name) > 20)
{
    set_message(MESSAGE_SIGNUP_ERROR);
    header("Location: signup.php");
    exit();
}

$password = (string)filter_input(INPUT_POST, "password");
if ($password === "")
{
    set_message(MESSAGE_SIGNUP_ERROR);
    header("Location: signup.php");
    exit();
}
if (mb_strlen($password) > 20)
{
    set_message(MESSAGE_SIGNUP_ERROR);
    header("Location: signup.php");
    exit();
}
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = new_PDO();

    $account_dao = new AccountDAO($pdo);
    $account_dao->insert($name, $hashed_password);
    set_message(MESSAGE_SIGNUP_SUCCESS);
    header("Location: signin.php");
} catch (PDOException $e) {
    if ($e->getCode() == 23000)
    {
        set_message(MESSAGE_SIGNUP_ERROR_NOT_AVAILABLE_NAME);
        header("Location: signup.php");
        exit();
    }
    error_log($e->getMessage());
    header("Location: error.php");
}