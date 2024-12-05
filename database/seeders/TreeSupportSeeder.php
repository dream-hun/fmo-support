<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreeSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/tree-support.csv');

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
                'avocadoes' => $row[1] ?: null,
                'mangoes' => $row[2] ?: null,
                'oranges' => $row[3] ?: null,
                'papaya' => $row[4] ?: null,
                'tree_id' => $row[0],
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }

        fclose($handle);

        if (! empty($newRecords)) {
            DB::table('trees_supports')->insert($newRecords);
            $this->command->info('Fruits Tree Data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header or all rows are duplicates.');
        }
    }
}
