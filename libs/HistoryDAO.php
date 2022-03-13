<?php

class HistoryDAO
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert($account_id, $section_id)
    {
        $sql = "insert into histories (account_id, section_id)
                values (:account_id, :section_id)";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":account_id", $account_id, PDO::PARAM_INT);
        $ps->bindValue(":section_id", $section_id, PDO::PARAM_INT);
        $ps->execute();
    }
}