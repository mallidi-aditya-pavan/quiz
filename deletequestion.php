<?php
include "connection.php"; // Include your database connection file

if (isset($_POST['qno'])) {
    $qno = $_POST['qno']; // Get the question number

    // SQL query to delete the question
    $query = "DELETE FROM questions WHERE qno = $qno";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 1; // Success response
    } else {
        echo 0; // Failure response
    }
}
?>
