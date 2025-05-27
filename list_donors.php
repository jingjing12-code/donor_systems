<?php
require 'db.php';

$donors = [];
$total = 0.0;

$sql = "SELECT name, purok, barangay, amount, date_donated FROM donors ORDER BY date_donated DESC";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
        $total += floatval($row['amount']);
    }
    $result->free();
} else {
    die("Error fetching donor data: " . $conn->error);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Donors List - San Lorenzo Ruiz Shrine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center text-success">Donors List - San Lorenzo Ruiz Shrine</h1>
        <a href="add_donor.php" class="btn btn-primary mb-3">Add New Donor</a>
        <a href="total_donation.php" class="btn btn-info mb-3">View Total Donations</a>


        <?php if (count($donors) === 0): ?>
            <p>No donors have been recorded yet.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Name</th>
                        <th>Purok</th>
                        <th>Barangay</th>
                        <th>Amount Donated</th>
                        <th>Date Donated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donors as $donor): ?>
                        <tr>
                            <td><?= htmlspecialchars($donor['name']) ?></td>
                            <td><?= htmlspecialchars($donor['purok']) ?></td>
                            <td><?= htmlspecialchars($donor['barangay']) ?></td>
                            <td>₱<?= number_format(floatval($donor['amount']), 2) ?></td>
                            <td><?= htmlspecialchars($donor['date_donated']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="alert alert-success fw-bold text-end">
                Total Amount Donated: ₱<?= number_format($total, 2) ?>
            </div>
            <div class="text-center">
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            <?php endif; ?>
        </div>
</body>

</html>