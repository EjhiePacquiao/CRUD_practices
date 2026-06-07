<?php
include "db.php";

$rows = [];
$totalRegistered = 0;
$totalAttendees = 0;
$totalCollection = 0;

if (isset($_POST['generate'])) {
    $result = $conn->query("SELECT campus, COUNT(*) as registered, SUM(attended='Yes') as attended, SUM(amountPaid) as totalCollection FROM registration GROUP BY campus");
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
        $totalRegistered += $row['registered'];
        $totalAttendees += $row['attended'];
        $totalCollection += $row['totalCollection'];
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>REPORT(SUMMARY)</title>
</head>

<body>
    <h5><a href="menu.php">&larr;Back to Menu</a></h5>
    <h2>Summary Report (All Campuses)</h2>

    <form method="POST" action="report_summary.php">
        <input type="submit" name="generate" value="Generate Report">
    </form>
    <br>

    <?php if (!empty($rows)): ?>
        <table border="1" cellspacing="8" cellpadding="0">
            <thead>
                <tr>
                    <td>Campus</td>
                    <td>Registered</td>
                    <td>Attended</td>
                    <td>Total Collections</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['campus']) ?></td>
                        <td><?= $row['registered'] ?></td>
                        <td><?= $row['attended'] ?></td>
                        <td><?= $row['totalCollection'] ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td><strong>TOTALS</strong></td>
                    <td><strong><?= $totalRegistered ?></strong></td>
                    <td><strong><?= $totalAttendees ?></strong></td>
                    <td><strong><?= $totalCollection ?></strong></td>
                </tr>
            </tbody>

        </table>
        <br>
        <p>Date Generated: <?= date('m/d/y') ?> </p>
    <?php endif; ?>
</body>

</html>