 

<?php
// Database connection parameters
$servername = "localhost:3306";
$username = "root";
$password = "pass123";
$dbname = "SNFEfficiency";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to delete all records from your_table_name
$sql = "DELETE FROM Employee";
$sql = "DELETE FROM efficiency";
// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>