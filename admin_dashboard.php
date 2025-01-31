<?php
// Database connection (replace with your own credentials)
include 'conn.php'; // Assumed to be your database connection file

// Fetch menus and submenus from the database
$menus = [];

$menuQuery = "SELECT * FROM menus WHERE parent_id = 0";  // Get top-level menus
$menuResult = $conn->query($menuQuery);

while ($menu = $menuResult->fetch_assoc()) {
    $submenuQuery = "SELECT * FROM menus WHERE parent_id = " . $menu['id'];  // Get submenus for the current menu
    $submenuResult = $conn->query($submenuQuery);
    
    $submenus = [];
    while ($submenu = $submenuResult->fetch_assoc()) {
        $submenus[] = $submenu;  // Store submenu data
    }
    
    $menus[] = [
        'title' => $menu['title'],
        'id' => $menu['id'],
        'submenus' => $submenus
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar Style */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar .menu-item {
            padding: 15px;
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .sidebar .menu-item:hover {
            background-color: #495057;
        }
        .sidebar .submenu {
            display: none;
            padding-left: 30px;
        }
        .sidebar .submenu a {
            padding: 10px;
        }
        .sidebar .active > .submenu {
            display: block;
        }
        /* Content Style */
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        /* Toggle button for small screens */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
            .sidebar .menu-item {
                text-align: center;
            }
            .sidebar .submenu {
                display: block;
                padding-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="container">
        <!-- Logo -->
        <h2 class="text-white text-center mb-4">Admin Panel</h2>

        <!-- Dynamically Render Menu Items from Database -->
        <?php foreach ($menus as $menu): ?>
            <a href="#" class="menu-item" data-bs-toggle="collapse" data-bs-target="#menu-<?php echo strtolower(str_replace(' ', '_', $menu['title'])); ?>">
                <?php echo $menu['title']; ?>
            </a>
            <div class="submenu" id="menu-<?php echo strtolower(str_replace(' ', '_', $menu['title'])); ?>">
                <?php foreach ($menu['submenus'] as $submenu): ?>
                    <a href="<?php echo $submenu['link']; ?>" class="menu-item"><?php echo $submenu['title']; ?></a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Main Content -->
<div class="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome to the Admin Panel</h1>
        <p>Manage the system easily from here.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle Submenu on click
    document.querySelectorAll('.menu-item[data-bs-toggle="collapse"]').forEach(item => {
        item.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('data-bs-target'));
            target.classList.toggle('active');
        });
    });
</script>

</body>
</html>
