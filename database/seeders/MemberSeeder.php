<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Seed the members table with data from a CSV file.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/members.csv');

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

        $existingIdNumbers = DB::table('members')->pluck('id_number')->toArray();
        $newRecords = [];

        while (($data = fgetcsv($handle)) !== false) {
            $idNumber = $data[3] ?? null;

            // Skip duplicate or null id_number entries
            if (is_null($idNumber) || in_array($idNumber, $existingIdNumbers)) {
                continue;
            }

            $newRecords[] = [
                'vsla_id' => $data[0] ?? null,
                'name' => $data[1] ?? null,
                'gender' => $data[2] ?? null,
                'id_number' => $idNumber,
                'mobile' => $this->phoneNumberFormat($data[4] ?? ''),
                'sector' => $data[5] ?? null,
                'cell' => $data[6] ?? null,
                'village' => $data[7] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add to the list of existing id_numbers
            $existingIdNumbers[] = $idNumber;
        }

        fclose($handle);

        if (! empty($newRecords)) {
            DB::table('members')->insert($newRecords);
            $this->command->info('Members data seeded successfully.');
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
