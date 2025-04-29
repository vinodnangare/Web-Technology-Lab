<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
  
    <script>
        function deleteEmployee() {
            let empId = prompt("Enter Employee ID to delete:");
            if (empId) {
                document.forms["f1"]["t2"].value = empId;
                document.forms["f1"]["b3"].click();
            }
        }

        function updateEmployee() {
            let empId = prompt("Enter Employee ID to update:");
            if (empId) {
                document.forms["f1"]["t2"].value = empId;
                document.forms["f1"]["fetch"].value = "true";
                document.forms["f1"].submit();
            }
        }
    </script>
</head>
<body>

    <form name="f1" method="post">
        <table>
            <tr><td>Employee Name:</td><td><input type="text" name="t1" required></td></tr>
            <tr><td>Employee ID:</td><td><input type="number" name="t2"></td></tr>
            <tr><td>New Employee ID:</td><td><input type="number" name="new_t2"></td></tr>
            <tr><td>Employee Email:</td><td><input type="email" name="t3" required></td></tr>
            <tr><td>Employee Mobile:</td><td><input type="number" name="t4" required></td></tr>
            <tr><td>Employee Address:</td><td><input type="text" name="t5" required></td></tr>
        </table>

        <input type="hidden" name="fetch" value="false">
        <input type="submit" name="b1" value="Add">
        <input type="submit" name="b2" value="Update">
        <input type="submit" name="b3" value="Delete" style="display:none;">
        <input type="submit" name="b4" value="Display">
    </form>

    <button onclick="updateEmployee()">Update Employee</button>
    <button onclick="deleteEmployee()">Delete Employee</button>

    <?php
    $conn = new mysqli("localhost", "root", "root", "employee_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['b1'])) {
        $id = $_POST['t2'];
        $name = $_POST['t1'];
        $email = $_POST['t3'];
        $mobile = $_POST['t4'];
        $address = $_POST['t5'];

        if (empty($id)) {
            $sql = "INSERT INTO employees (name, email, mobile, address) 
                    VALUES ('$name', '$email', '$mobile', '$address')";
        } else {
            $sql = "INSERT INTO employees (employee_id, name, email, mobile, address) 
                    VALUES ('$id', '$name', '$email', '$mobile', '$address')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Employee Added Successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if (isset($_POST['b2'])) {
        $id = intval($_POST['t2']);
        $new_id = intval($_POST['new_t2']);
        $name = $_POST['t1'];
        $email = $_POST['t3'];
        $mobile = $_POST['t4'];
        $address = $_POST['t5'];

        if ($id > 0 && $new_id > 0) {
            $sql = "UPDATE employees SET employee_id='$new_id', name='$name', email='$email', mobile='$mobile', address='$address' WHERE employee_id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "Employee Updated Successfully";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Invalid Employee ID!";
        }
    }

    if (isset($_POST['b3'])) {
        $id = intval($_POST['t2']);

        if ($id > 0) {
            $sql = "DELETE FROM employees WHERE employee_id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "Employee Deleted Successfully";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Invalid Employee ID!";
        }
    }

    if ($_POST['fetch'] === "true") {
        $id = intval($_POST['t2']);
        $sql = "SELECT * FROM employees WHERE employee_id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<script>
                    document.forms['f1']['t1'].value = '{$row['name']}';
                    document.forms['f1']['new_t2'].value = '{$row['employee_id']}';
                    document.forms['f1']['t3'].value = '{$row['email']}';
                    document.forms['f1']['t4'].value = '{$row['mobile']}';
                    document.forms['f1']['t5'].value = '{$row['address']}';
                  </script>";
        } else {
            echo "<script>alert('Employee not found!');</script>";
        }
    }

    if (isset($_POST['b4'])) {
        $sql = "SELECT * FROM employees";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='emp-table'><tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Address</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['employee_id']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['mobile']}</td><td>{$row['address']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No Employees Found";
        }
    }

    $conn->close();
    ?>
</body>
</html>
