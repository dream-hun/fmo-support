<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MalnutritionSeeder extends Seeder
{
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
        $rowNumber = 1; // Start after header

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            // Ensure the row has enough columns
            $row = array_pad($row, 10, null);

            try {
                $newRecords[] = [
                    'name' => $row[0] ?? null,
                    'gender' => $row[1] ?? null,
                    'age_or_months' => $row[2] ?? null,
                    'associated_health_center' => $row[3] ?? null,
                    'sector' => $row[4] ?? null,
                    'cell' => $row[5] ?? null,
                    'village' => $row[6] ?? null,
                    'father_name' => $row[7] ?? null,
                    'mother_name' => $row[8] ?? null,
                    'home_phone_number' => $this->phoneNumberFormat($row[9] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } catch (\Exception $e) {
                $this->command->warn("Error processing row {$rowNumber}: ".$e->getMessage());
                \Log::warning('Malformed CSV row', [
                    'row_number' => $rowNumber,
                    'row_data' => $row,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        fclose($handle);

        if (! empty($newRecords)) {
            DB::table('malnutritions')->insert($newRecords);
            $this->command->info('Malnutition data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header or all rows are duplicates.');
        }
    }

    private function phoneNumberFormat(?string $phoneNumber): string
    {
        if (empty($phoneNumber)) {
            return '';
        }

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
