<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MalnutritionSupportSeeder extends Seeder
{
    public function run(): void
    {
        // Path to the CSV file
        $csvFile = base_path('database/seeders/data/malnutrition-support.csv');

        // Open and read CSV
        $data = array_map('str_getcsv', file($csvFile));
        $header = array_map('trim', array_shift($data)); // Remove and trim header row

        foreach ($data as $row) {
            // Skip empty rows or improperly formatted data
            if (count($row) !== count($header)) {
                continue;
            }

            $row = array_combine($header, $row); // Map CSV columns to associative array

            // Note the trimmed column name to remove the trailing space
            $formattedDate = $this->formatDate($row['package_reception_date']);

            // Only insert if date is valid
            if ($formattedDate !== null) {
                DB::table('malnutrition_supports')->insert([
                    'malnutrition_id' => $row['malnutrition_id'],
                    'package_reception_date' => $formattedDate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Format date from "DD/MM/YYYY" to "YYYY-MM-DD".
     */
    private function formatDate(string $date): ?string
    {
        try {
            return Carbon::createFromFormat('d/m/Y', trim($date))->format('Y-m-d');
        } catch (\Exception $e) {
            // Handle invalid dates by logging or other error handling
            return null;
        }
    }
}
