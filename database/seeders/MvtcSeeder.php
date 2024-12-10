<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MvtcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFile = database_path('seeders/data/mvtc.csv');
        $firstRow = true;

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                // Skip header row
                if ($firstRow) {
                    $firstRow = false;

                    continue;
                }

                DB::table('mvtcs')->insert([
                    'reg_no' => $row[0] ?? null,
                    'name' => $row[1] ?? null,
                    'gender' => $row[2] ?? null,
                    'dob' => ! empty($row[3]) ? $row[3] : null,
                    'student_id' => $row[4] ?? null,
                    'student_contact' => $this->formatPhoneNumber($row[5]) ?? null,
                    'trade' => $row[6] ?? null,
                    'resident_district' => $row[7] ?? null,
                    'sector' => $row[8] ?? null,
                    'cell' => $row[9] ?? null,
                    'village' => $row[10] ?? null,
                    'education_level' => $row[11] ?? null,
                    'scholar_type' => $row[12] ?? null,
                    'intake' => $row[13] ?? null,
                    'graduation_date' => $row[14] ?? null,
                    'status' => $row[15] ?? null,
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
    private function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If number starts with 7, add Rwanda country code
        if (strlen($phone) == 9 && str_starts_with($phone, '7')) {
            return '+250'.$phone;
        }

        return $phone;
    }
}
