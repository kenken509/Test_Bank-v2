<?php

namespace App\Http\Controllers;

use Log;
use PDOException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use PHPUnit\TextUI\Configuration\Exception;
use Symfony\Component\Process\Exception\ProcessFailedException;


class BackUpController extends Controller
{
    public function download()
    {
        $mysqldumpPath = 'C:/xampp/mysql/bin/mysqldump';
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $filename = "backup-{$database}-" . date('Y-m-d_H-i-s') . ".sql";
        $backupFile = "C:/xampp/htdocs/Test_Bank-v1-main/public/backup/{$filename}";
    
        try {
            // Construct the command
            $command = "\"$mysqldumpPath\" --user=$username --password=$password --host=$host $database > \"$backupFile\"";
            exec($command, $output, $returnVar);
            //dd('i');
            if ($returnVar !== 0) {
                throw new Exception("mysqldump command failed with return code $returnVar");
            }
            
            
            // Read the backup file content
            $backupContent = file_get_contents($backupFile);
            
            return response($backupContent)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (Exception $e) {
            Log::error('Error running mysqldump command: ' . $e->getMessage());
            throw $e;
        } finally {
            // Clean up the backup file
            if (file_exists($backupFile)) {
                unlink($backupFile);
            }
        }
    }
    


     public function testDatabaseConnection()
    {
        try {
            // Attempt to connect to the database using Laravel's DB facade
            DB::connection()->getPdo();

            // Dump the output if connection is successful
            dd("Connected successfully to MySQL server");
        } catch (PDOException $e) {
            // Dump the error message if connection fails
            dd("Connection failed: " . $e->getMessage());
        }
    }

}
