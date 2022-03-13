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

    public function selectByAccountId($account_id)
    {
        $sql = "select
                    co.id course_id,
                    co.title course_title,
                    se.id section_id,
                    se.title section_title,
                    se.no section_no,
                    hi.created_at
                from
                    histories hi
                    inner join sections se on hi.section_id = se.id
                    inner join courses co on se.course_id = co.id
                where
                    hi.account_id = :account_id
                order by
                    hi.created_at desc";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":account_id", $account_id, PDO::PARAM_INT);
        $ps->execute();
        $histories = $ps->fetchAll();
        return $histories;
    }
}