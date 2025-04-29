<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 5</title>
    <script>
        function validateForm() {
            let f = document.forms["f1"];
            if (f.t1.value.trim() === "" || f.t2.value.trim() === "" || f.t3.value.trim() === "" || f.t4.value.trim() === "" || f.t5.value.trim() === "") {
                alert("All fields are required!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

    <form name="f1" method="post" onsubmit="return validateForm()">
        <table>
            <tr><td>Employee Name:</td><td><input type="text" name="t1"></td></tr>
            <tr><td>Employee ID:</td><td><input type="number" name="t2"></td></tr>
            <tr><td>Employee Email:</td><td><input type="email" name="t3"></td></tr>
            <tr><td>Employee Mobile:</td><td><input type="number" name="t4"></td></tr>
            <tr><td>Employee Address:</td><td><input type="text" name="t5"></td></tr>
        </table>

        <input type="submit" name="b1" value="Add">
        <input type="submit" name="b2" value="Update">
        <input type="submit" name="b3" value="Delete">
        <input type="submit" name="b4" value="Display">
    </form>

    <?php
    $conn = new mysqli("localhost", "root", "root", "student_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['t1'];
        $employee_id = $_POST['t2'];
        $email = $_POST['t3'];
        $mobile = $_POST['t4'];
        $address = $_POST['t5'];

        if (isset($_POST['b1'])) {
            $sql = "INSERT INTO students (name, employee_id, email, mobile, address) VALUES ('$name', '$employee_id', '$email', '$mobile', '$address')";
            echo $conn->query($sql) ? "Employee Added Successfully" : "Error: " . $conn->error;
        }

        if (isset($_POST['b2'])) {
            $sql = "UPDATE students SET name='$name', email='$email', mobile='$mobile', address='$address' WHERE employee_id='$employee_id'";
            echo $conn->query($sql) ? "Employee Updated Successfully" : "Error: " . $conn->error;
        }

        if (isset($_POST['b3'])) {
            $sql = "DELETE FROM students WHERE employee_id='$employee_id'";
            echo $conn->query($sql) ? "Employee Deleted Successfully" : "Error: " . $conn->error;
        }

        if (isset($_POST['b4'])) {
            $result = $conn->query("SELECT * FROM students");
            if ($result->num_rows > 0) {
                echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Address</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row['employee_id']."</td><td>".$row['name']."</td><td>".$row['email']."</td><td>".$row['mobile']."</td><td>".$row['address']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No employees found.";
            }
        }
    }

    $conn->close();
    ?>

</body>
</html>
