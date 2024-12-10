<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScholarshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/scholaships.csv');

        $firstRow = true;

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {

                // Skip header row
                if ($firstRow) {
                    $firstRow = false;

                    continue;
                }

                DB::table('scholarships')->insert([
                    'name' => $row[0],
                    'gender' => $row[1] ?: null,
                    'national_id_number' => $row[2] ?: null,
                    'district' => $row[3] ?: null,
                    'sector' => $row[4] ?: null,
                    'cell' => $row[5] ?: null,
                    'village' => $row[6] ?: null,
                    'telephone' => $this->formatPhoneNumber($row[7]) ?: null,
                    'email' => $row[8] ?: null,
                    'university_attended' => $row[9] ?: null,
                    'faculty' => $row[10] ?: null,
                    'program_duration' => $row[11] ?: null,
                    'year_of_entrance' => $row[12] ?: null,
                    'intake' => $row[13] ?: null,
                    'school_contact' => $row[14] ?: null,
                    'status' => $row[15] ?: null,

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
