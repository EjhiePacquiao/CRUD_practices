<?php
include "db.php";

$idNum = $campus = $studFName = $studLName = $amountPaid = "";

//delete - when delete is clicked this runs
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $stmt = $conn->prepare("DELETE FROM registration WHERE idNum=?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo "<script>alert('succesfully deleted record');</script>";
    } else {
        echo "<script>alert('error deleting record');</script>";
    }
    $stmt->close();
    echo "<script>window.location.href='registration.php';</script>";
    exit;
}
//CREATE para maka create og new registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete'])) {
    $idNum = trim($_POST['idNum'] ?? "");
    $campus = trim($_POST['campus'] ?? "");
    $studFName = trim($_POST['studFName'] ?? "");
    $studLName = trim($_POST['studLName'] ?? "");
    $amountPaid = trim($_POST['amountPaid'] ?? "");

    if (empty($idNum) || empty($campus) || empty($studFName) || empty($studLName) || empty($amountPaid)) {
        echo "<script>alert('All fields are required!');</script>";
    } elseif (!is_numeric($amountPaid) || $amountPaid <= 0) {
        echo "<script>alert('Amount must be a valid number');</script>";
    } else {
        //insert
        $stmt = $conn->prepare("INSERT INTO registration (idNum, campus, studFName, studLName, amountPaid) VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssssd", $idNum, $campus, $studFName, $studLName, $amountPaid);

        if ($stmt->execute()) {
            echo "<script>alert('succesfully created record');</script>";
            echo "<script>window.location.href='registration.php';</script>";
            exit;
        } else {
            echo "<script>alert('failed creating record');</script>";
        }
        $stmt->close();
    }
}

//read
$result = $conn->query("SELECT * FROM registration ORDER BY idNum ASC");

?>

<!DOCTYPE html>
<html>

<head>
    <title>REGISTRATION</title>
</head>

<body>
    <h5><a href="menu.php">&larr; Back to Menu</a></h5>
    <h3>REGISTRATION</h3>
    <fieldset>
        <legend>REGISTER A STUDENT</legend>
        <table>
            <form method="POST" action="registration.php">
                <label>ID: </label><br>
                <input type="number" name="idNum" value="<?= htmlspecialchars($idNum) ?>"><br><br>

                <label>Campus: </label><br>
                <select name="campus">
                    <option value="">-- select campus --</option>
                    <?php
                    $campuses = ["Main", "Banilad", "METC", "UC-PT", "UCLM"];
                    foreach ($campuses as $c) {
                        $selected = ($campus == $c) ? "selected" : "";
                        echo "<option value='$c' $selected>$c</option>";
                    }
                    ?>
                </select><br><br>

                <label>First Name: </label><br>
                <input type="text" name="studFName" value="<?= htmlspecialchars($studFName) ?>"><br><br>

                <label>Last Name: </label><br>
                <input type="text" name="studLName" value="<?= htmlspecialchars($studLName) ?>"><br><br>

                <label>Amount Paid: </label><br>
                <input type="number" name="amountPaid" value="<?= htmlspecialchars($amountPaid) ?>"><br><br><br>


                <input type="submit" value="Register Student">
            </form>
        </table>
    </fieldset>

    <br>
    <br>
    <fieldset>
        <legend>Registered Student</legend>

        <?php if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <td>ID#</td>
                        <td>Campus</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Amount</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['idNum'] ?></td>
                            <td><?= htmlspecialchars($row['campus']) ?></td>
                            <td><?= htmlspecialchars($row['studFName']) ?></td>
                            <td><?= htmlspecialchars($row['studLName']) ?></td>
                            <td><?= htmlspecialchars($row['amountPaid']) ?></td>
                            <td>
                                <a href="edit_registration.php?id=<?= $row['idNum'] ?>">Edit</a> |
                                <form method="POST" action="registration.php"
                                    onsubmit="return confirm('Are you sure you want to delete this students?')"
                                    style="display:inline;">
                                    <input type="hidden" name="delete" value="<?= $row['idNum'] ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h4>No Registration Found.</h4>
        <?php endif; ?>
    </fieldset>
</body>

</html>
<?php $conn->close(); ?>