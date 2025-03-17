<?php
// Database credentials
$db_host = "153.92.15.32";
$db_user = "u432621597_test_db";
$db_pass = "sA#>A^0d";
$db_name = "u432621597_test_db";

// Backup file name
$backup_file = __DIR__ . '/backup_' . date("Y-m-d_H-i-s") . '.sql';

// Escape credentials (for security)
$escaped_user = escapeshellarg($db_user);
$escaped_pass = escapeshellarg($db_pass);
$escaped_db   = escapeshellarg($db_name);
$escaped_file = escapeshellarg($backup_file);

// Full path to `mysqldump`
$mysqldump_path = "C:\\xampp\\mysql\\bin\\mysqldump.exe"; // Windows
// $mysqldump_path = "/usr/bin/mysqldump"; // Linux/Mac

// Run mysqldump with `--column-statistics=0`
$command = "\"$mysqldump_path\" --host=$db_host --user=$escaped_user --password=$escaped_pass --column-statistics=0 $escaped_db > $escaped_file 2>&1";

// Execute the command and capture errors
exec($command, $output, $result_code);

// Debugging: Log output if it fails
if ($result_code !== 0 || filesize($backup_file) === 0) {
    echo "Error: Failed to create database backup.\n";
    echo "Command: $command\n";
    echo "Output: " . implode("\n", $output);
    exit;
}

echo "Backup successful: $backup_file";
?>
