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
}