<?php
require 'db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $purok = trim($_POST['purok']);
    $barangay = $conn->real_escape_string(trim($_POST['barangay']));
    $amount = floatval($_POST['amount']);
    $date = $conn->real_escape_string($_POST['date_donated']);

    if ($name === '' || $barangay === '' || $date === '' || $amount <= 0) {
        $msg = "Please provide valid name, barangay, date, and amount.";
    } else {
        $stmt = $conn->prepare("INSERT INTO donors (name, purok, barangay, amount, date_donated) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('sssss', $name, $purok, $barangay, $amount, $date);
            if ($stmt->execute()) {
                $msg = "Donor added successfully!";
            } else {
                $msg = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $msg = "Database prepare error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add Donor - San Lorenzo Ruiz Shrine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center text-success">Add Donor - San Lorenzo Ruiz Shrine</h1>

        <?php if ($msg): ?>
            <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="name" class="form-label">Donor Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required />
                <div class="invalid-feedback">Please enter the donor's name.</div>
            </div>
            <div class="col-md-6">
                <label for="purok" class="form-label">Purok <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="purok" name="purok" required />
                <div class="invalid-feedback">Please enter the purok.</div>
                <div class="col-md-6">
                    <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="barangay" name="barangay" required />
                    <div class="invalid-feedback">Please enter the barangay.</div>
                </div>
                <div class="col-md-3">
                    <label for="amount" class="form-label">Amount Donated <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" class="form-control" id="amount" name="amount" required />
                    <div class="invalid-feedback">Please enter a valid donation amount.</div>
                </div>
                <div class="col-md-3">
                    <label for="date_donated" class="form-label">Date Donated <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date_donated" name="date_donated" required />
                    <div class="invalid-feedback">Please select the date donated.</div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Add Donor</button>
                    <a href="list_donors.php" class="btn btn-secondary ms-2">View Donors List</a>
                </div>
                <div class="col-12 mt-3">
                    <a href="index.php" class="btn btn-primary">Back to Home</a>
        </form>

        <script>
            (() => {
                'use strict'
                let forms = document.querySelectorAll('.needs-validation');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', e => {
                        if (!form.checkValidity()) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        </script>

</body>

</html>