<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EcdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/ecd.csv');

        $firstRow = true;

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {

                // Skip header row
                if ($firstRow) {
                    $firstRow = false;

                    continue;
                }

                DB::table('ecds')->insert([
                    'name' => $row[0],
                    'gender' => $row[2] ?: null,
                    'birthday' => $row[3] ?: null,
                    'sector' => $row[5] ?: null,
                    'cell' => $row[6] ?: null,
                    'village' => $row[7] ?: null, // Handle empty value
                    'father_name' => $row[8] ?: null,
                    'father_id_number' => $row[9] ?: null,
                    'mother_name' => $row[10] ?: null,
                    'home_phone_number' => $this->formatPhoneNumber($row[11]) ?: null,
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
        //Remove any non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);
        //If number starts with 7 add rwanda country code
        if (strlen($number) == 9 && str_starts_with($number, '7')) {
            return '+250'.$number;
        }

        return $number;
    }
}
