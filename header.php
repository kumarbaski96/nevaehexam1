<?php
include 'conn.php';

// Fetch parent menus (parent_id = NULL)
$menus = [];
$query = "SELECT * FROM menu WHERE parent_id IS NULL ORDER BY sort_order";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $menus[$row['id']] = $row;
    $menus[$row['id']]['submenus'] = [];
}

// Fetch submenus (parent_id IS NOT NULL)
$query = "SELECT * FROM menu WHERE parent_id IS NOT NULL ORDER BY sort_order";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $menus[$row['parent_id']]['submenus'][] = $row;
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Exam Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($menus as $menu): ?>
                    <?php if (!empty($menu['submenus'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown<?= $menu['id'] ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= htmlspecialchars($menu['name']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown<?= $menu['id'] ?>">
                                <?php foreach ($menu['submenus'] as $submenu): ?>
                                    <li><a class="dropdown-item" href="<?= htmlspecialchars($submenu['link']) ?>"><?= htmlspecialchars($submenu['name']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= htmlspecialchars($menu['link']) ?>"><?= htmlspecialchars($menu['name']) ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Exam Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="show_candidate.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="single_question_bank.php">Create Single Question</a></li>
                <li class="nav-item"><a class="nav-link" href="multiple_question_bank.php">Create Multiple Question</a></li>
                <li class="nav-item"><a class="nav-link" href="show_question.php">Show Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="add_question.php">Add Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="add_bulk_question.php">Add bulk Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="show_exam_type.php">Show Exam Type</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav> -->