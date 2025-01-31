<?php
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personal Details</title> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <script>
        function fetchCandidateDetails() {
            let candidateId = document.getElementById('search_candidate_id').value.trim();
            if (candidateId === "") {
                alert("Please enter a Candidate ID.");
                return;
            }

            fetch(`fetch_candidate.php?candidate_id=${candidateId}`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched Data:", data); // Debugging

                if (data.error) {
                    alert(data.error);
                } else {
                    document.querySelector("input[name='candidate_id']").value = data.candidate_id;
                    document.querySelector("input[name='dob']").value = data.dob;
                    document.querySelector("select[name='gender']").value = data.gender;
                    document.querySelector("input[name='nationality']").value = data.nationality;
                    document.querySelector("textarea[name='address']").value = data.address;
                    document.querySelector("input[name='city']").value = data.city;
                    document.querySelector("input[name='state']").value = data.state;
                    document.querySelector("input[name='zip_code']").value = data.zip_code;
                    document.getElementById('editForm').style.display = "block"; // Show form
                }
            })
            .catch(error => {
                console.error("Error fetching candidate:", error);
                alert("Error fetching candidate data.");
            });
        }

        function updateCandidateDetails(event) {
            event.preventDefault(); // Prevent form submission

            let formData = new FormData(document.getElementById("editForm"));

            fetch("update_personal_details.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Update Response:", data); // Debugging

                if (data.success) {
                    alert("Candidate details updated successfully!");
                } else {
                    alert("Update failed: " + data.error);
                }
            })
            .catch(error => {
                console.error("Error updating candidate:", error);
                alert("Error updating candidate details.");
            });
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Personal Details</h2>

        <!-- Candidate Search -->
        <div class="mb-3">
            <label class="form-label">Search Candidate ID</label>
            <div class="input-group">
                <input type="number" id="search_candidate_id" value="<?php echo $id?>" class="form-control" placeholder="Enter Candidate ID">
                <button class="btn btn-primary" onclick="fetchCandidateDetails()">Search</button>
            </div>
        </div>

        <!-- Edit Form (Initially Hidden) -->
        <form id="editForm" style="display:none;" onsubmit="updateCandidateDetails(event)">
            <div class="mb-3">
                <label class="form-label">Candidate ID</label>
                <input type="number" name="candidate_id" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nationality</label>
                <input type="text" name="nationality" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Zip Code</label>
                <input type="text" name="zip_code" class="form-control">
            </div>
            <button type="submit" class="btn btn-success w-100">Update</button>
        </form>
    </div>
</body>
</html>
