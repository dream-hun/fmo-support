<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolFeedingSupport extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/school-feeding-payment.csv');

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

        $newRecords = [];

        while (($row = fgetcsv($handle)) !== false) {

            $newRecords[] = [
                'school_feeding_id' => $row[0],
                'academic_year' => $row[1],
                'trimester' => $row[2] ?: null,
                'amount' => $row[3],
                'status' => $row[4] ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }

        fclose($handle);

        if (! empty($newRecords)) {
            DB::table('school_feeding_payments')->insert($newRecords);
            $this->command->info('School feeding data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header or all rows are duplicates.');
        }
    }
}
