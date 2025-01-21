<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Bootstrap Page</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS (Optional) -->
    <style>
        body {
            padding-top: 60px; /* Adjust for fixed navbar */
        }
        .footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php
include 'conn.php'; // Database connection

// Fetch main menu items (parent_id is NULL)
$menu_query = "SELECT id, name, url FROM header WHERE parent_id IS NULL ORDER BY sort_order ASC";
$menu_result = $conn->query($menu_query);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: orange;" href="#">Nevaeh Technology</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                if ($menu_result->num_rows > 0) {
                    while ($row = $menu_result->fetch_assoc()) {
                        $menu_id = $row['id'];
                        $menu_name = htmlspecialchars($row['name']);
                        $menu_url = htmlspecialchars($row['url']);

                        // Check for submenus
                        $submenu_query = "SELECT name, url FROM header WHERE parent_id = $menu_id ORDER BY sort_order ASC";
                        $submenu_result = $conn->query($submenu_query);

                        if ($submenu_result->num_rows > 0) {
                            // If submenus exist, create a dropdown
                            echo '<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="menu' . $menu_id . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
                                    . $menu_name . 
                                    '</a>
                                    <ul class="dropdown-menu" aria-labelledby="menu' . $menu_id . '">';

                            while ($submenu = $submenu_result->fetch_assoc()) {
                                echo '<li><a class="dropdown-item" href="' . htmlspecialchars($submenu['url']) . '">' . htmlspecialchars($submenu['name']) . '</a></li>';
                            }

                            echo '</ul></li>';
                        } else {
                            // Regular menu item
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="' . $menu_url . '">' . $menu_name . '</a>
                                  </li>';
                        }
                    }
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="#">No menu items</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>


    <!-- Navbar -->
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">My Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav> -->

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1>Welcome to My Bootstrap Page</h1>
                <p>This is a simple Bootstrap boilerplate with a responsive navbar and footer.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 My Website | All Rights Reserved
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
