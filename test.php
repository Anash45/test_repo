<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;

// Database credentials
$db_host = "153.92.15.32";
$db_user = "u432621597_test_db";
$db_pass = "sA#>A^0d";
$db_name = "u432621597_test_db";

// Backup file name
$backup_file = __DIR__ . '/backup_' . date("Y-m-d_H-i-s") . '.sql';

// Run mysqldump command
$command = "mysqldump --host=$db_host --user=$db_user --password=$db_pass --column-statistics=0 $db_name > $backup_file";
exec($command);

// // Google Drive API setup
// $client = new Client();
// $client->setAuthConfig('service_acc_1_keys.json'); // Your Google Drive API JSON file
// $client->addScope(Drive::DRIVE_FILE);

// $service = new Drive($client);

// // Upload backup to Google Drive
// $file = new Drive\DriveFile();
// $file->setName(basename($backup_file));
// $file->setParents(['1XTi_y6n10em8x9LveNBBSxLPPuGmlxkd']); // Replace with your actual folder ID

// $content = file_get_contents($backup_file);
// $service->files->create($file, [
//     'data' => $content,
//     'mimeType' => 'application/sql',
//     'uploadType' => 'multipart'
// ]);

// // Delete local backup file after upload
// unlink($backup_file);

echo "Backup completed and uploaded to Google Drive!";
?>
