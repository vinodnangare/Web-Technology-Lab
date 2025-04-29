<?php
$conn = mysqli_connect("localhost", "root", "root", "employee_db");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['t1'])) {
    $employee_id = intval($_POST['t1']);
    $sql = "DELETE FROM employees WHERE employee_id = $employee_id";

    if (mysqli_query($conn, $sql)) {
        echo "Employee Deleted Successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid Employee ID!";
}

mysqli_close($conn);
?>
