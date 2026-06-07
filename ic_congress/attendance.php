<?php
include "db.php";

$message = "";
$student = null;

//mark as atttend
if (isset($_POST['mark'])) {
    $idNum = trim($_POST['idNum'] ?? "");

    //check if student exists
    $stmt = $conn->prepare("SELECT * FROM registration WHERE idNum=? ");
    $stmt->bind_param("s", $idNum);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if (!$student) {
        $message = "<script>alert('Student not found.');</script>";
    } elseif ($student['attended'] == 'Yes') {
        $message = "<script>alert('Student record already exists!');</script>";
    } else {
        $stmt = $conn->prepare("UPDATE registration SET attended='Yes' WHERE idNum=?");
        $stmt->bind_param("s", $idNum);

        if ($stmt->execute()) {
            $message = "<script>alert('Student Attendance Successfully Recorded!');</script>";
            $student['attended'] = 'Yes';
        }
        $stmt->close();
    }
}
echo $message;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Attendance</title>
</head>

<body>
    <h5><a href="menu.php">&larr;Back to Menu</a></h5>

    <h3>Attendance</h3>
    <form method="POST" action="attendance.php">
        <label>Input ID#: </label>
        <input type="text" name="idNum">
        <input type="submit" name="mark" value="Mark Attend">
    </form>

    <br>
    <?php if ($student): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <td>ID#</td>
                    <td>NAME</td>
                    <td>CAMPUS</td>
                    <td>AMOUNT</td>
                    <td>ACTION</td>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td><?= $student['idNum'] ?></td>
                    <td><?= $student['studFName'] . ' ' . $student['studLName'] ?></td>
                    <td><?= $student['campus'] ?></td>
                    <td><?= $student['amountPaid'] ?></td>
                    <td><?= $student['attended'] ?></td>
                </tr>

            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>