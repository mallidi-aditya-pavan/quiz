<?php session_start(); ?>
<?php include "connection.php";
if (isset($_SESSION['admin'])) {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Include jQuery -->
	<style>
		/* style1.css */

/* General Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Container for header */
.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

/* Table Styling */
table.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 16px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table.data-table thead {
    background-color: #333;
    color: #fff;
}

table.data-table th,
table.data-table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: center;
}

table.data-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table.data-table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Buttons inside table (Edit and Delete) */
table.data-table a,
table.data-table button {
    text-decoration: none;
    padding: 8px 15px;
    font-size: 14px;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    background-color: #77aaff;
    border: none;
}

table.data-table a:hover,
table.data-table button:hover {
    background-color: #5588ee;
}

/* Delete button specific styles */
table.data-table button.delete-btn {
    background-color: #e74c3c; /* Red color for delete */
}

table.data-table button.delete-btn:hover {
    background-color: #c0392b; /* Darker red on hover */
}

/* Caption styling */
table.data-table caption {
    caption-side: top;
    font-size: 20px;
    font-weight: bold;
    padding: 10px;
    color: #333;
}

/* Footer Styling */
footer {
    background: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    margin-top: 30px;
}

footer p {
    margin: 0;
}

	</style>
</head>

<body>
    <header>
        <div class="container">
            <h1>Quiz</h1>
            <!-- Navigation bar styled with the same 'a.start' class -->
            <nav>
                <a href="index.php" class="start">Home</a>
                <a href="add.php" class="start">Add Question</a>
                <a href="allquestions.php" class="start">All Questions</a>
                <a href="players.php" class="start">Players</a>
                <a href="exit.php" class="start">Logout</a>
            </nav>
        </div>
    </header>

    <h1>All Questions</h1>
    <table class="data-table">
        <caption class="title">All Quiz Questions</caption>
        <thead>
            <tr>
                <th>Q.NO</th>
                <th>Question</th>
                <th>Option1</th>
                <th>Option2</th>
                <th>Option3</th>
                <th>Option4</th>
                <th>Correct Answer</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        
        <?php 
        $query = "SELECT * FROM questions ORDER BY qno DESC";
        $select_questions = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if (mysqli_num_rows($select_questions) > 0) {
            while ($row = mysqli_fetch_array($select_questions)) {
                $qno = $row['qno'];
                $question = $row['question'];
                $option1 = $row['ans1'];
                $option2 = $row['ans2'];
                $option3 = $row['ans3'];
                $option4 = $row['ans4'];
                $Answer = $row['correct_answer'];
                echo "<tr id='row-$qno'>";
                echo "<td>$qno</td>";
                echo "<td>$question</td>";
                echo "<td>$option1</td>";
                echo "<td>$option2</td>";
                echo "<td>$option3</td>";
                echo "<td>$option4</td>";
                echo "<td>$Answer</td>";
                echo "<td> <a href='editquestion.php?qno=$qno'> Edit </a></td>";
                echo "<td> <button class='delete-btn' data-qno='$qno'>Delete</button></td>";
                echo "</tr>";
            }
        }
        ?>
    
        </tbody>
    </table>

    <script>
    // AJAX function to delete a question
    $(document).on('click', '.delete-btn', function() {
        var qno = $(this).data('qno'); // Get the question number
        if (confirm('Are you sure you want to delete this question?')) {
            $.ajax({
                url: 'deletequestion.php', // Backend PHP file to handle deletion
                type: 'POST',
                data: { qno: qno },
                success: function(response) {
                    if (response == 1) {
                        $('#row-' + qno).remove(); // Remove the row from the table
                        alert('Question deleted successfully');
                    } else {
                        alert('Failed to delete question');
                    }
                }
            });
        }
    });
    </script>
</body>
</html>

<?php } else {
    header("location: admin.php");
}
?>
