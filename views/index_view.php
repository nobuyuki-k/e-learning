<!DOCTYPE html>
<html lang="ja">
<head>
    <?php require("_head_view.php"); ?>
</head>
<body>
    <?php require("_header_view.php"); ?>
    <main class="container py-4">
        <div class="row mt-3">
            <div class="col-12">
                <h3>Courses</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <?php foreach($courses as $course): ?>
            <div class="col-md-3">
                <div class="card mb-4 shadow-sm">
                    <img src="img/courses/<?= h($course['id']) ?>.png" alt="course image">
                    <div class="card-body">
                        <h5 class="card-title"><?= h($course['course_title']) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= h($course['category_title']) ?></h6>
                        <a href="detail.php?course_id=<?= h($course['id']) ?>"
                            class="btn btn-sm btn-outline-secondary">View</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php require("_footer_view.php"); ?>
</body>
</html>