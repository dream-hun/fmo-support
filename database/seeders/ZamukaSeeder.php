<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZamukaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/zamuka.csv');

        $firstRow = true;

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {

                // Skip header row
                if ($firstRow) {
                    $firstRow = false;

                    continue;
                }

                DB::table('zamukas')->insert([
                    'head_of_household_name' => $row[0],
                    'household_id_number' => $row[1] ?: null,
                    'spouse_name' => $row[2] ?: null,
                    'spouse_id_number' => $row[3] ?: null,
                    'sector' => $row[4] ?: null,
                    'cell' => $row[5] ?: null,
                    'village' => $row[6] ?: null,
                    'house_hold_phone' => $this->formatPhoneNumber($row[7]) ?: null, // Handle empty value
                    'family_size' => $row[8] ?: null,
                    'main_source_of_income' => $row[9] ?: null,
                    'entrance_year' => $row[10] ?: null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            fclose($handle);
        }

    }

    /**
     * Format phone number to include country code if missing
     */
    private function formatPhoneNumber(string $number): ?string
    {
        if (empty($number)) {
            return null;
        }
        // Remove any non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        // If number starts with 7 add rwanda country code
        if (strlen($number) == 9 && str_starts_with($number, '7')) {
            return '+250'.$number;
        }

        return $number;
    }
}
