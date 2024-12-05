<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolkitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('database/seeders/data/toolkits.csv');

        if (! file_exists($filePath)) {
            $this->command->error("File not found at: $filePath");

            return;
        }

        $csvData = array_map('str_getcsv', file($filePath));
        $headers = array_map('trim', $csvData[0]);
        $records = array_slice($csvData, 1);

        $existingIds = DB::table('toolkits')->pluck('identification_number')->toArray();

        foreach ($records as $record) {
            $toolkitData = array_combine($headers, $record);
            $toolkitData = $this->sanitizeData($toolkitData);

            if (! $this->isValidRwandanNationalId($toolkitData['identification_number']) || in_array($toolkitData['identification_number'], $existingIds)) {
                continue;
            }

            $toolkitData['reception_date'] = $this->parseDate($toolkitData['reception_date']);
            $toolkitData['phone_number'] = $this->formatPhoneNumber($toolkitData['phone_number']);
            $toolkitData['created_at'] = now();
            $toolkitData['updated_at'] = now();

            DB::table('toolkits')->insert($toolkitData);
        }
    }

    /**
     * Sanitize the input data by trimming values and converting empty strings to null.
     */
    private function sanitizeData(array $data): array
    {
        return array_map(function ($value) {
            $trimmedValue = trim($value);

            return $trimmedValue === '' ? null : $trimmedValue;
        }, $data);
    }

    /**
     * Validate the identification number as a Rwandan National ID.
     * A valid Rwandan ID is 16 digits long and numeric.
     */
    private function isValidRwandanNationalId(?string $id): bool
    {
        return ! is_null($id) && preg_match('/^\d{16}$/', $id);
    }

    /**
     * Parse date into 'Y-m-d' format, or return null if invalid.
     */
    private function parseDate(?string $date): ?string
    {
        if (is_null($date)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Format phone number to include Rwanda's country code if applicable.
     */
    private function formatPhoneNumber(?string $phone): ?string
    {
        if (is_null($phone)) {
            return null;
        }

        $phone = preg_replace('/\D/', '', $phone);

        if (strlen($phone) === 9 && str_starts_with($phone, '7')) {
            return '+250'.$phone;
        }

        return $phone;
    }
}
