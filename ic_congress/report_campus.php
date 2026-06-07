<?php
include "db.php";

$rows = [];
$totalCollection = 0;
$totalAttendees = 0;
$campus = "";

if (isset($_POST['generate'])) {
    $campus = $_POST['campus'];

    $stmt = $conn->prepare("SELECT * FROM registration WHERE campus=?");
    $stmt->bind_param("s", $campus);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
        $totalCollection += $row['amountPaid'];
        if ($row['attended'] == 'Yes') {
            $totalAttendees++;
        }
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Report(Campus)</title>
</head>

<body>
    <h5><a href="menu.php">&larr;Back to Menu</a></h5>
    <h3>Raffle</h3>

    <form method="POST" action="report_campus.php">
        <label>Select Campus: </label>
        <select name="campus">
            <option value="">--select campus--</option>
            <option value="Main">Main</option>
            <option value="Banilad">Banilad</option>
            <option value="UCPT">UCPT</option>
            <option value="UCLM"> UCLM</option>
        </select><br><br>
        <input type="submit" name="generate" value="GET REPORT">
    </form>
    <br><br>

    <?php if (!empty($rows)): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <td>ID#</td>
                    <td>NAME</td>
                    <td>CAMPUS</td>
                    <td>AMOUNT PAID</td>
                    <td>ATTENDED</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $row['idNum'] ?></td>
                        <td><?= htmlspecialchars($row['studFName'] . ' ' . $row['studLName']) ?></td>
                        <td><?= htmlspecialchars($row['campus']) ?></td>
                        <td><?= $row['amountPaid'] ?></td>
                        <td><?= $row['attended'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <p># of Registrants: <?= count($rows) ?></p>
        <p># of Attendees: <?= $totalAttendees ?></p>
        <p>Total of Collections: <?= $totalCollection ?></p>
    <?php endif; ?>
</body>

</html>