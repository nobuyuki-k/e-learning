<?php
require_once("../libs/functions.php");

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

    $sql = "select
                co.id,
                co.title course_title,
                ca.title category_title
            from
                courses co
                inner join categories ca on co.category_id = ca.id
            where
                co.id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":id", $course_id, PDO::PARAM_INT);
    $ps->execute();
    $course = $ps->fetch();
    if ($course === false)
    {
        error_log("Invalid course.id." . $course_id);
        header("Location: error.php");
        exit();
    }

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
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":course_id", $course_id, PDO::PARAM_INT);
    $ps->execute();
    $sections = $ps->fetchAll();
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

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="/" class="navbar-brand ">
                    <strong>E-Learning</strong>
                </a>
            </div>
        </nav>
    </header>
    <main class="container py-4">
        <div class="row mt-3">
            <div class="col-12">
                <h3>Sections</h3>
                <hr>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <img src="img/courses/<?= h($course['id']) ?>.png" alt="course image">
                    <div class="card-body">
                        <h5 class="card-title"><?= h($course['course_title']) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= h($course['category_title']) ?></h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach($sections as $section): ?>
                        <li class="list-group-item">
                            <a href="detail.php?course_id=<?= h($course['id']) ?>&section_id=<?= h($section['id']) ?>">
                                Section <?= h($section['no']) ?> : <?= h($section['title']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 mb-4">
                <video src="<?= h($current_section['url']) ?>" 
                    playsinline controls class="section-video"></video>
                <hr>
                <h5 class="my-4">
                    <?= h($course['course_title']) ?> - Section <?= h($current_section['no']) ?> :
                    <?= h($current_section['title']) ?>
                </h5>
            </div>
        </div>
    </main>
    <footer class="footer bg-secondary text-white">
        <div class="container">
            <span>E-Learning</span>
        </div>
    </footer>
</body>
</html>