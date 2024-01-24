





<?php
// Database connection parameters
$servername = "localhost:3306";
$username = "root";
$password = "pass123";
$dbname = "SNFEfficiency";

// File path
$filePath = "/home/swaraj/Desktop/new_php/Employee_informtaion.txt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the file exists
if (!file_exists($filePath)) {
    die("File not found: $filePath");
}

// Read data from the text file
$data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Check if data is not empty
if (!$data) {
    die("No data found in the file.");
}

// Process each line and insert into the database
foreach ($data as $line) {
    // Assuming each line contains values separated by a comma
    $values = explode(',', $line);

    // SQL query to insert data into the database
    $sql = "INSERT INTO Employee (ID, First_Name, Last_Name) VALUES ('$values[0]', '$values[1]', '$values[2]')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
