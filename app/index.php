<?php
require_once("../libs/functions.php");
require_once("../libs/CourseDAO.php");

try {
    $pdo = new_PDO();

    $course_dao = new CourseDAO($pdo);
    $courses = $course_dao->selectAll();

    require("../views/index_view.php");
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}