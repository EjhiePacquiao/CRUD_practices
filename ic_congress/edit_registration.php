<?php
include "db.php";

$student = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM registration WHERE idNum=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

//UPDATE WHEN FORM ID SUBMITTED
if (isset($_POST['update'])) {
    $id = $_POST['idNum'];
    $campus = $_POST['campus'];
    $studFName = $_POST['studFName'];
    $studLName = $_POST['studLName'];
    $amountPaid = $_POST['amountPaid'];

    $stmt = $conn->prepare("UPDATE registration SET campus=?, studFName=?, studLName=?, amountPaid=? WHERE idNum=?");
    $stmt->bind_param("sssds", $campus, $studFName, $studLName, $amountPaid, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Record Sucessfully Updated!');</script>";
        echo "<script>window.location.href='registration.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed Updating Record!');</script>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Registration</title>
</head>

<body>

    <h5><a href="registration.php">&larr;Back to Registration</a></h5>

    <legend>Update Student Info</legend>

    <?php if ($student): ?>
        <form method="POST" action="edit_registration.php">
            <input type="hidden" name="idNum" value="<?= $student['idNum'] ?>">

            <label>ID Number: </label><br>
            <input type="text" value="<?= $student['idNum'] ?>" disabled><br><br>

            <label>Campus: </label><br>
            <select name="campus">
                <option value="">-- select campus --</option>
                <?php
                $campuses = ["Main", "Banilad", "UCPT", "UCLM"];
                foreach ($campuses as $c) {
                    $selected = ($student['campus'] == $c) ? "selected" : "";
                    echo "<option value='$c' $selected>$c</option>";
                }
                ?>
            </select><br><br>

            <label>First Name: </label><br>
            <input type="text" name="studFName" value="<?= htmlspecialchars($student['studFName']) ?>"><br><br>

            <label>Last Name: </label><br>
            <input type="text" name="studLName" value="<?= htmlspecialchars($student['studLName']) ?>"><br><br>

            <label>Amount Paid: </label><br>
            <input type="number" name="amountPaid" value="<?= htmlspecialchars($student['amountPaid']) ?>"><br><br><br>

            <input type="submit" name="update" value="Update Student">
        </form>
    <?php else: ?>
        <p>No Student Found</p>
    <?php endif; ?>

</body>

</html>