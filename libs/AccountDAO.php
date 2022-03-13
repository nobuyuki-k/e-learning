<?php

class AccountDAO
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectByName($name)
    {
        $sql = "select
                    id,
                    name,
                    hashed_password
                from
                    accounts
                where
                    name = :name";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":name", $name, PDO::PARAM_STR);
        $ps->execute();
        $account = $ps->fetch();
        return $account;
    }

    public function insert($name, $hashed_password)
    {
        $sql = "insert into accounts (name, hashed_password) values (:name, :hashed_password)";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":name", $name, PDO::PARAM_STR);
        $ps->bindValue(":hashed_password", $hashed_password, PDO::PARAM_STR);
        $ps->execute();
    }
}