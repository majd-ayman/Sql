<?php
include('config.php'); 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Employees WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "<p class='error'>Error deleting record: " . $conn->error . "</p>";
    }
} else {
    echo "<p class='error'>Invalid request. No ID provided.</p>";
}
?>
