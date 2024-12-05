<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UrgentSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/urgentsupport.csv');

        if (! file_exists($csvFile) || ! is_readable($csvFile)) {
            $this->command->error("CSV file does not exist or is not readable: $csvFile");

            return;
        }

        if (($handle = fopen($csvFile, 'r')) === false) {
            $this->command->error("Failed to open CSV file: $csvFile");

            return;
        }

        // Skip the header row explicitly
        $header = fgetcsv($handle);

        if (! $header) {
            $this->command->warn('The CSV file is empty or has no header.');
            fclose($handle);

            return;
        }

        $records = [];
        while (($data = fgetcsv($handle)) !== false) {
            $records[] = [
                'urgent_id' => $data[0] ?? null,
                'support_received' => $data[1] ?? null,
                'done_at' => $this->formatDate($data[2]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        fclose($handle);

        if (! empty($records)) {
            DB::table('urgent_supports')->insert($records);
            $this->command->info('Urgent support data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header.');
        }
    }

    /**
     * Format date from d/m/Y to Y-m-d using Carbon
     */
    private function formatDate(?string $date): ?string
    {
        if (! $date) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (Exception $e) {
            $this->command->warn("Invalid date format: $date");

            return $e->getMessage();
        }
    }
}
