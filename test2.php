<?php
require 'vendor/autoload.php'; // Google Drive API if needed

use Google\Client;
use Google\Service\Drive;

// Database credentials
$db_host = "153.92.15.32";
$db_user = "u432621597_test_db";
$db_pass = "sA#>A^0d";
$db_name = "u432621597_test_db";

// Backup file name
$backup_file = __DIR__ . '/backup_' . date("Y-m-d_H-i-s") . '.sql';

// Connect to MySQL
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open the backup file for writing
$file = fopen($backup_file, 'w');
if (!$file) {
    die("Failed to create backup file.");
}

// Write the database structure
$tables = $conn->query("SHOW TABLES");
while ($table = $tables->fetch_array()) {
    $table_name = $table[0];

    // Get table creation SQL
    $create_table = $conn->query("SHOW CREATE TABLE `$table_name`")->fetch_array()[1];
    fwrite($file, "-- Table structure for `$table_name`\n");
    fwrite($file, "DROP TABLE IF EXISTS `$table_name`;\n");
    fwrite($file, "$create_table;\n\n");

    // Get table data
    $result = $conn->query("SELECT * FROM `$table_name`");
    while ($row = $result->fetch_assoc()) {
        $values = array_map(function ($value) use ($conn) {
            return "'" . $conn->real_escape_string($value) . "'";
        }, array_values($row));

        $sql = "INSERT INTO `$table_name` VALUES (" . implode(", ", $values) . ");\n";
        fwrite($file, $sql);
    }
    fwrite($file, "\n");
}

// Close file and database connection
fclose($file);
$conn->close();

echo "Backup created: $backup_file";
?>
