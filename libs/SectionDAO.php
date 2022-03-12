<?php

class SectionDAO
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectByCourseId($course_id)
    {
        $sql = "select
                    se.id,
                    se.title,
                    se.no,
                    se.url,
                    se.course_id
                from
                    sections se
                where
                    se.course_id = :course_id
                order by
                    se.no";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":course_id", $course_id, PDO::PARAM_INT);
        $ps->execute();
        $sections = $ps->fetchAll();
        return $sections;
    }
}