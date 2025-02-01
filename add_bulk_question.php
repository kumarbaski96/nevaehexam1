<?php
include 'conn.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST["upload"])) {
    if ($_FILES["csv_file"]["error"] == 0) {
        $filename = $_FILES["csv_file"]["tmp_name"];

        if (($handle = fopen($filename, "r")) !== FALSE) {
            fgetcsv($handle); // Skip header row
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $exam_type = $conn->real_escape_string($data[0]);
                $question = $conn->real_escape_string($data[1]);
                $option1 = $conn->real_escape_string($data[2]);
                $option2 = $conn->real_escape_string($data[3]);
                $option3 = $conn->real_escape_string($data[4]);
                $option4 = $conn->real_escape_string($data[5]);
                $correct_option = (int)$data[6];
                $level = (int)$data[7];

                $sql = "INSERT INTO questions (exam_type, question, option1, option2, option3, option4, correct_option, level, status)
                        VALUES ('$exam_type', '$question', '$option1', '$option2', '$option3', '$option4', '$correct_option', '$level', 1)";
                
                if (!$conn->query($sql)) {
                    $message = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
                }
            }
            fclose($handle);
            $message = '<div class="alert alert-success">Bulk upload successful!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error opening the file!</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">File upload error!</div>';
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Upload Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-upload {
            width: 100%;
            background-color: #28a745;
            border: none;
        }
        .btn-upload:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php include 'header2.php';?>

<div class="container">
    <h2 class="text-center mb-4">Bulk Upload Questions</h2>
    
    <?php echo $message; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="csv_file" class="form-label">Upload CSV File</label>
            <input type="file" class="form-control" name="csv_file" accept=".csv" required>
        </div>
        <button type="submit" name="upload" class="btn btn-upload text-white">Upload CSV</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
