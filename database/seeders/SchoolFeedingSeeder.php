<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolFeedingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/schoolfeeding.csv');

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
                'name' => $row[0],
                'grade' => $row[1],
                'school' => $row[3] ?: null,
                'district' => $row[4],
                'sector' => $row[5],
                'cell' => $row[6],
                'village' => $row[7] ?: null,
                'father_name' => $row[8],
                'mother_name' => $row[9],
                'gender' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }

        fclose($handle);

        if (! empty($newRecords)) {
            DB::table('school_feedings')->insert($newRecords);
            $this->command->info('School feeding data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header or all rows are duplicates.');
        }
    }
}
