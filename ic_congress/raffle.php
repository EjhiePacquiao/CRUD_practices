<?php
include "db.php";
$winner = null;

if (isset($_POST['raffle'])) {
    $campus = $_POST['campus'];

    $stmt = $conn->prepare("SELECT * FROM registration WHERE campus=? ORDER BY RAND() LIMIT 1");
    $stmt->bind_param("s", $campus);
    $stmt->execute();
    $result = $stmt->get_result();
    $winner = $result->fetch_assoc();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>RAFFLE</title>
</head>

<body>
    <h5><a href="menu.php">&larr;Back to Menu</a></h5>
    <h3>Raffle</h3>

    <form method="POST" action="raffle.php">
        <label>Select Campus: </label>
        <select name="campus">
            <option value="">--select campus--</option>
            <option value="Main">Main</option>
            <option value="Banilad">Banilad</option>
            <option value="UCPT">UCPT</option>
            <option value="UCLM"> UCLM</option>
        </select><br><br>
        <input type="submit" name="raffle" value="Reveal the Lucky Winner!">
    </form>
    <br><br>

    <?php if ($winner): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <td>ID#</td>
                    <td>NAME</td>
                    <td>CAMPUS</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $winner['idNum'] ?></td>
                    <td><?= htmlspecialchars($winner['studFName'] . ' ' . $winner['studLName']) ?></td>
                    <td><?= htmlspecialchars($winner['campus']) ?></td>
                </tr>
            </tbody>
        </table>
        <h2>CONGRATUFUCKINGLATIONS!!!!</h2>
    <?php endif; ?>
</body>

</html>