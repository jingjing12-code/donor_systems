<?php
require_once 'db.php';


$barangay_totals = [];


$sql = "SELECT barangay, SUM(amount) AS total_amount FROM donors GROUP BY barangay ORDER BY barangay ASC";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $barangay_totals[] = $row;
    }
} else {
    die("Error fetching donor data: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Total Donations by Barangay - San Lorenzo Ruiz Shrine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #eef5eb;
            padding-top: 4rem;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        h1 {
            color: #2e7d32;
            font-weight: 700;
            margin-bottom: 3rem;
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            text-align: center;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Total Donations by Barangay - San Lorenzo Ruiz Shrine</h1>

        <?php if (count($barangay_totals) > 0): ?>
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Barangay</th>
                        <th>Total Amount Donated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($barangay_totals as $barangay): ?>
                        <tr>
                            <td><?= htmlspecialchars($barangay['barangay']) ?></td>
                            <td>₱<?= number_format(floatval($barangay['total_amount']), 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">No donations recorded yet.</div>
        <?php endif; ?>

        <div class="container text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>

</html>