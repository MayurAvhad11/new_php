<?php
// Database connection parameters
$servername = "localhost:3306";
$username = "root";
$password = "pass123";
$dbname = "SNFEfficiency";

// File paths and corresponding table names
$fileMappings = [
    "/home/swaraj/Desktop/new_php/Employee_informtaion.txt" => "Employee",
    "/home/swaraj/Desktop/new_php/Efficiency_informtaion.txt" => "efficiency",
    "/home/swaraj/Desktop/new_php/Schedule_informtaion.txt" => "Schedule"
];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process each file and insert into the corresponding table
foreach ($fileMappings as $filePath => $tableName) {
    // Check if the file exists
    if (!file_exists($filePath)) {
        die("File not found: $filePath");
    }

    // Read data from the text file
    $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Check if data is not empty
    if (!$data) {
        die("No data found in the file: $filePath");
    }

    // Process each line and insert into the database
    foreach ($data as $line) {
        // Assuming each line contains values separated by a comma
        $values = explode(',', $line);

        // Adjust the SQL query based on the structure of the table
        if ($tableName === "Employee") {
            $sql = "INSERT INTO $tableName (ID,	First_Name,	Last_Name) VALUES ('$values[0]', '$values[1]', '$values[2]')";
        } elseif ($tableName === "efficiency") {
            // Adjust the query for the second table
            $sql = "INSERT INTO $tableName (ID, start_time, stop_time, total_time, individual_machine_efficiency) VALUES ('$values[0]', '$values[1]', '$values[2]', '$values[3]', '$values[4]')";
            //3)$sql = "INSERT INTO $tableName (ID, start_time, stop_time, total_time, individual_machine_efficiency) VALUES ('$values[0]', '$values[1]', '$values[2]', " . intval(trim($values[3])) . ", '$values[4]')";
            //$sql = "INSERT INTO $tableName (ID, start_time, stop_time, total_time, individual_machine_efficiency) VALUES ('$values[0]', '$values[1]', '$values[2]', '" . sprintf('%d', trim($values[3])) . "', '$values[4]')";

            //1)$sql = "INSERT INTO $tableName (ID, start_time, stop_time, total_time, individual_machine_efficiency) VALUES ('$values[0]', '$values[1]', '$values[2]', '" . trim($values[3]) . "', '$values[4]')";

        } elseif ($tableName === "Schedule") {
            // Adjust the query for the third table
           // $sql = "INSERT INTO $tableName (ID,	Machine_Number,	Machine_Name, Worker_Name, Date, Shift) VALUES ('$values[0]', '$values[1]', '$values[2]', '$values[3]', '$values[4]', '$values[5]')";
           $sql = "INSERT INTO $tableName (ID, Machine_Number, Machine_Name, Worker_Name, Date, Shift) VALUES ('$values[0]', '$values[1]', '$values[2]', '$values[3]', '$values[4]', '$values[5]')";

        }

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully into $tableName<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
