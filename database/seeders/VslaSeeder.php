<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VslaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/vslas.csv');
        $firstRow = true;

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                // Skip header row
                if ($firstRow) {
                    $firstRow = false;

                    continue;
                }

                DB::table('vslas')->insert([
                    'code' => $row[0],
                    'name' => $row[1],
                    'representative_name' => $row[2],
                    'representative_id' => $row[3],
                    'representative_phone' => $this->phoneNumberFormat($row[4]) ?: null,
                    'sector' => $row[5],
                    'cell' => $row[6],
                    'village' => $row[7] ?: null, // Handle empty value
                    'entrance_year' => $row[8] ?: null,
                    'mou_sign_date' => $this->parseDate($row[9]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            fclose($handle);
        }
    }

    /**
     * Format phone numbers to standard rwandan phone numbers
     */
    private function phoneNumberFormat(string $phoneNumber): string
    {
        if (empty($phoneNumber)) {
            return '';
        }
        // Remove any non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        // Add rwandan country code
        if (strlen($phoneNumber) == 9 && str_starts_with($phoneNumber, '7')) {
            return '+250'.$phoneNumber;
        }

        return $phoneNumber;

    }

    /**
     * Parse date from CSV format to database format
     */
    private function parseDate(string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('n/j/Y', $date)->format('d-m-Y');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
