<?php
// Start session or initialize environment
session_start();

// Check if 'id' is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID not provided.";
    exit;
}

// Retrieve and sanitize the ID
$candidate_id = intval($_GET['id']);

// Database connection
include 'conn.php';
//$conn = new mysqli("localhost", "root", "", "nevaeh_exam");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidate's name and exam type from the `candidates` table
$candidate_sql = "SELECT name, exam_type FROM candidates WHERE id = $candidate_id";
$candidate_result = $conn->query($candidate_sql);

if ($candidate_result->num_rows === 0) {
    echo "Candidate not found.";
    exit;
}

$candidate = $candidate_result->fetch_assoc();

// Fetch results from the `question_results` table
$results_sql = "SELECT * FROM question_results WHERE candidate_id = $candidate_id";
$results = $conn->query($results_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Candidate Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Candidate Exam Results</h2>
    <div class="mb-4">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($candidate['name']); ?></p>
        <p><strong>Exam Type:</strong> <?php echo htmlspecialchars($candidate['exam_type']); ?></p>
    </div>

    <?php if ($results->num_rows > 0) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Your Answer</th>
                        <th>Correct Answer</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 1;
                    while ($row = $results->fetch_assoc()) { 
                        $status_class = $row['status'] === 'Correct' ? 'text-success' : 'text-danger';
                    ?>
                        <tr>
                            <td><?php echo $index++; ?></td>
                            <td><?php echo htmlspecialchars($row['question']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_answer']); ?></td>
                            <td><?php echo htmlspecialchars($row['correct_option']); ?></td>
                            <td class="<?php echo $status_class; ?>"><?php echo $row['status']; ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="text-center text-warning">No results found for Candidate ID: <?php echo $candidate_id; ?></p>
    <?php } ?>
    <a href="javascript:void(0);" class="btn btn-secondary" onclick="window.location.href='show_candidate.php';">Go Back</a>
    <!--div class="go-back-container"-->
    <!--h2>Go Back to the Previous Page</h2>
    <button class="go-back-btn" onclick="window.location.href='index.php';">Go Back</button>
</div>
</div>
</body>
</html>
