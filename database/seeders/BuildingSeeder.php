<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user to assign buildings to
        $userId = DB::table('users')->first()->id ?? 1;

        // Clear existing buildings first
        DB::table('buildings')->delete();
        echo "Cleared existing buildings...\n";

        // Define JSON file paths
        $jsonFiles = [
            base_path('skyscrapers.json'),
        ];

        $buildings = [];
        $totalProcessed = 0;

        foreach ($jsonFiles as $jsonFile) {
            echo "Processing file: " . basename($jsonFile) . "\n";
            
            if (file_exists($jsonFile)) {
                $jsonData = json_decode(file_get_contents($jsonFile), true);
                
                if ($jsonData === null) {
                    echo "Error: Could not decode JSON from " . basename($jsonFile) . "\n";
                    continue;
                }
                
                foreach ($jsonData as $index => $building) {
                    try {
                        // Extract height (remove " / xx ft" part and any "+" symbols)
                        $height = explode(' / ', $building['Height'])[0];
                        $height = str_replace('+', '', $height);
                        
                        // Map status codes to readable format
                        $statusMap = [
                            'COM' => 'Completed',
                            'UC' => 'Under Construction',
                            'UCT' => 'Architecturally Topped Out',
                            'PRO' => 'Proposed'
                        ];
                        
                        $status = $statusMap[$building['Status']] ?? $building['Status'];
                        
                        // Handle completion year (0, ?, or null means unknown/not set)
                        $completionYear = $building['Completion'];
                        if ($completionYear === 0 || $completionYear === '?' || $completionYear === null || $completionYear === '' || $completionYear === "?") {
                            $completionYear = 2025; // Default to current year for unknown completion dates
                        }
                        
                        // Ensure completion year is an integer
                        $completionYear = (int) $completionYear;
                        if ($completionYear < 1900 || $completionYear > 2100) {
                            $completionYear = 2025;
                        }
                        
                        // Handle material (N/A means not available)
                        $material = ($building['Material'] === 'N/A') ? '' : $building['Material'];
                        
                        // Handle floors - ensure it's an integer
                        $floors = (int) $building['Floors'];
                        if ($floors <= 0) {
                            $floors = 1; // Default to 1 floor if invalid
                        }
                        
                        $buildings[] = [
                            'name' => $building['Building Name'],
                            'city' => $building['City'],
                            'country' => $building['Country'],
                            'status' => $status,
                            'completion_year' => $completionYear,
                            'height' => $height,
                            'floors' => $floors,
                            'material' => $material,
                            'function' => $building['Function'],
                            'user_id' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        
                        $totalProcessed++;
                        
                    } catch (Exception $e) {
                        echo "Error processing building at index $index in " . basename($jsonFile) . ": " . $e->getMessage() . "\n";
                        continue;
                    }
                }
                
                echo "Processed " . count($jsonData) . " buildings from " . basename($jsonFile) . "\n";
            } else {
                echo "File not found: " . basename($jsonFile) . "\n";
            }
        }

        echo "Total buildings to insert: " . count($buildings) . "\n";

        // Insert buildings in chunks to avoid memory issues with large datasets
        if (!empty($buildings)) {
            $chunks = array_chunk($buildings, 100);
            foreach ($chunks as $chunkIndex => $chunk) {
                try {
                    DB::table('buildings')->insert($chunk);
                    echo "Inserted chunk " . ($chunkIndex + 1) . " (" . count($chunk) . " buildings)\n";
                } catch (Exception $e) {
                    echo "Error inserting chunk " . ($chunkIndex + 1) . ": " . $e->getMessage() . "\n";
                }
            }
        }

        echo "Seeding completed. Total processed: $totalProcessed\n";
    }
}
