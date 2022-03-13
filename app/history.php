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

try {
    $pdo = new_PDO();

    $history_dao = new HistoryDAO($pdo);
    $histories = $history_dao->selectByAccountId($account_id);
    if (count($histories) === 0)
    {
        set_message(MESSAGE_NO_LEARNING_HISTORY);
    }

    require("../views/history_view.php");
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}