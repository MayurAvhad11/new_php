<?php
// Database connection parameters
$servername = "localhost:3306";
$username = "root";
$password = "pass123";
$dbname = "SNFEfficiency";

// File path
$filePath = "/home/swaraj/Desktop/new_php/Efficiency_informtaion.txt";

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

// Process each line and insert or update into the database
foreach ($data as $line) {
    // Assuming each line contains values separated by a comma
    $values = explode(',', $line);

    // Trim whitespaces from the 'total_time' value
    $totalTime = trim($values[3]);

    // Remove any non-numeric characters from 'total_time'
    $totalTime = preg_replace('/[^0-9]/', '', $totalTime);

    // SQL query to update or insert data into the database
    $sql = "INSERT INTO efficiency (ID, start_time, stop_time, total_time, individual_machine_efficiency) 
            VALUES ('$values[0]', '$values[1]', '$values[2]', '$totalTime', '$values[4]')
            ON DUPLICATE KEY UPDATE 
            start_time = '$values[1]', stop_time = '$values[2]', total_time = '$totalTime', individual_machine_efficiency = '$values[4]'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted or updated successfully for ID: $values[0]<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
