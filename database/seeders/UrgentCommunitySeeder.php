<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UrgentCommunitySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/urgentcommunity.csv');

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

        $records = [];
        while (($data = fgetcsv($handle)) !== false) {
            $records[] = [
                'name' => $data[0] ?? null,
                'national_id_number' => $data[1] ?? null,
                'district' => $data[2] ?? null,
                'sector' => $data[3] ?? null,
                'cell' => $data[4] ?? null,
                'village' => $data[5] ?? null,
                'phone_number' => $data[6] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        fclose($handle);

        if (! empty($records)) {
            DB::table('urgents')->insert($records);
            $this->command->info('Urgent community data seeded successfully.');
        } else {
            $this->command->warn('No valid data rows found in the CSV file after the header.');
        }
    }
}
