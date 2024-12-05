<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MusaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/musa.csv');

        $firstRow = true;

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {

                // Skip header row
                if ($firstRow) {
                    $firstRow = false;

                    continue;
                }

                DB::table('musas')->insert([
                    'head_of_family_name' => $row[0],
                    'national_id' => $row[1] ?: null,
                    'total_family_members' => $row[2] ?: null,
                    'district' => $row[3] ?: null,
                    'sector' => $row[4] ?: null,
                    'cell' => $row[5] ?: null,
                    'village' => $row[6] ?: null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            fclose($handle);
        }

    }
}
