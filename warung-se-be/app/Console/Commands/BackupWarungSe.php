<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupWarungSE extends Command
{
    protected $signature = 'backup:warungse';
    protected $description = 'Backup database Warung SE + auto delete';

    public function handle()
    {
        $this->info('Backup Warung SE dimulai...');

        // === Backup Database ===
        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');

        $filename = 'warungse_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backup/' . $filename);

        $command = "mysqldump -u{$user} -p{$pass} {$db} > {$path}";
        exec($command);

        $this->info('Backup database berhasil');

        // === AUTO DELETE BACKUP LAMA ===
        $files = Storage::disk('local')->files('backup');

        foreach ($files as $file) {
            $lastModified = Storage::disk('local')->lastModified($file);

            // Hapus jika lebih dari 1 hari
            if (now()->timestamp - $lastModified > 86400) {
                Storage::disk('local')->delete($file);
            }
        }

        $this->info('Auto-delete backup lama selesai');
    }
}
