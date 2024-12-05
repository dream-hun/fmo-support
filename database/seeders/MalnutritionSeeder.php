<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MalnutritionSeeder extends Seeder
{
    /**
     * Seed the members table with data from a CSV file.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/malnutrition.csv');

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
                'gender' => $row[1],
                'age_or_months' => $row[2] ?: null,
                'associated_health_center' => $row[3],
                'sector' => $row[4],
                'cell' => $row[5],
                'village' => $row[6] ?: null,
                'father_name' => $row[7],
                'mother_name' => $row[8],
                'home_phone_number' => $this->phoneNumberFormat($row[9]),
                'entry_muac' => $row[10],
                'current_muac' => $row[11],
                'status' => $row[12],
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }

        fclose($handle);

        if (! empty($newRecords)) {
            DB::table('malnutritions')->insert($newRecords);
            $this->command->info('Malnutition data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header or all rows are duplicates.');
        }
    }

    /**
     * Format phone numbers to standard Rwandan phone numbers.
     */
    private function phoneNumberFormat(string $phoneNumber): string
    {
        // Remove non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Skip invalid phone numbers
        if (empty($phoneNumber) || strlen($phoneNumber) < 9) {
            return '';
        }

        // Add Rwandan country code if the phone number starts with '7'
        if (strlen($phoneNumber) === 9 && str_starts_with($phoneNumber, '7')) {
            return '+250'.$phoneNumber;
        }

        // Return original if not matching expected format
        return $phoneNumber;
    }
}
