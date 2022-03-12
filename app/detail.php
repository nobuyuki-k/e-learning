<?php
require_once("../libs/functions.php");
require_once("../libs/CourseDAO.php");
require_once("../libs/SectionDAO.php");

$course_id = (string)filter_input(INPUT_GET, "course_id");
if ($course_id === "")
{
    error_log("Validate: course_id is not required.");
    header("Location: error.php");
    exit();
}
if (filter_var($course_id, FILTER_VALIDATE_INT) === false)
{
    error_log("Validate: course_id is not int.");
    header("Location: error.log");
    exit();
}

$section_id = (string)filter_input(INPUT_GET, "section_id");
if ($section_id !== "" && filter_var($section_id, FILTER_VALIDATE_INT) === false)
{
    error_log("Validate: section_id is not int.");
    header("Location: error.php");
    exit();
}

try {
    $pdo = new_PDO();

    $course_dao = new CourseDAO($pdo);
    $course = $course_dao->selectById($course_id);
    if ($course === false)
    {
        error_log("Invalid course.id." . $course_id);
        header("Location: error.php");
        exit();
    }

    $section_dao = new SectionDAO($pdo);
    $sections = $section_dao->selectByCourseId($course_id);
    if (count($sections) === 0) {
        error_log("Invalid sections." . $course_id);
        header("Location: error.php");
        exit();
    }

    $current_section = $sections[0];
    foreach($sections as $section)
    {
        if ((int)$section['id'] === (int)$section_id)
        {
            $current_section = $section;
            break;
        }
    }

    require("../views/detail_view.php");
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}