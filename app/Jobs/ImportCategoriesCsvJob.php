<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImportCategoriesCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 1200;

    public function __construct(public $path) {}

    public function handle()
    {
        DB::disableQueryLog();
        set_time_limit(0);

        try {

            $fullPath = Storage::path($this->path);

            if (!file_exists($fullPath)) {
                throw new \Exception("CSV file not found at: " . $fullPath);
            }

            $file = fopen($fullPath, 'r');

            $batch = [];
            $chunkSize = 1000;
            $rowCount = 0;
            $totalInserted = 0;

            while (($row = fgetcsv($file, 0, ',')) !== false) {

                if ($rowCount++ == 0) continue;

                if (count($row) < 6) {
                    Log::error('Invalid CSV row format', ['row' => $row]);
                    continue;
                }

                $name = trim($row[0] ?? '');

                if (empty($name)) {
                    Log::error('Category name missing', ['row' => $row]);
                    continue;
                }

                $batch[] = [
                    'name'        => $name,
                    'slug'        => Str::slug($name) . '-' . uniqid(),
                    'description' => $row[1] ?? null,
                    'parent_id'   => !empty($row[2]) ? (int)$row[2] : null,
                    'order'       => (isset($row[3]) && is_numeric($row[3])) ? (int)$row[3] : 0,
                    'image'       => $row[4] ?? null,
                    'is_active'   => isset($row[5]) ? (int)$row[5] : 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];

                if (count($batch) >= $chunkSize) {

                    DB::table('categories')->insert($batch);

                    $totalInserted += count($batch);

                    Log::info('Inserted chunk', [
                        'rows' => count($batch),
                        'total' => $totalInserted,
                        'time' => now()->toDateTimeString()
                    ]);

                    $batch = [];
                }
            }

            if (!empty($batch)) {

                DB::table('categories')->insert($batch);

                $totalInserted += count($batch);

                Log::info('Inserted final chunk', [
                    'rows' => count($batch),
                    'total' => $totalInserted,
                    'time' => now()->toDateTimeString()
                ]);
            }

            fclose($file);

            Log::info('Category CSV Import Completed', [
                'total_rows' => $totalInserted,
                'file' => $this->path
            ]);

        } catch (Throwable $e) {

            Log::error('Category CSV Import Failed', [
                'file' => $this->path,
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            throw $e; // failed_jobs me jayega
        }
    }
}
