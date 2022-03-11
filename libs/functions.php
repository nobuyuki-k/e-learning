<?php

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function new_PDO()
{
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    $pdo = new PDO("sqlite:../db/eldb.sqlite3", null, null, $options);
    return $pdo;
}
