
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Personal Details</h2>
        <form action="insert_personal_details.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Candidate ID</label>
                <input type="number" name="candidate_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nationality</label>
                <input type="text" name="nationality" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Zip Code</label>
                <input type="text" name="zip_code" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</body>
</html>



