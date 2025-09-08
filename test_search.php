<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test search functionality
$controller = new App\Http\Controllers\Api\BuildingController();
$request = new Illuminate\Http\Request();
$request->merge(['q' => 'Dubai', 'per_page' => 10]);

$response = $controller->search($request);
$data = json_decode($response->getContent(), true);

echo "Search Test Results (Dubai):\n";
echo "============================\n";
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
echo "Search query: " . $data['search_query'] . "\n";
echo "Total results: " . $data['pagination']['total'] . "\n";
echo "Buildings found:\n";
foreach ($data['data'] as $building) {
    echo "- {$building['name']} ({$building['city']}) - {$building['status']}\n";
}

echo "\n" . str_repeat("=", 50) . "\n";

// Test by status functionality
$request2 = new Illuminate\Http\Request();
$request2->merge(['per_page' => 5]);

$response2 = $controller->byStatus($request2, 'Completed');
$data2 = json_decode($response2->getContent(), true);

echo "Status Filter Test (Completed):\n";
echo "===============================\n";
echo "Success: " . ($data2['success'] ? 'Yes' : 'No') . "\n";
echo "Total completed buildings: " . $data2['pagination']['total'] . "\n";
echo "Sample completed buildings:\n";
foreach (array_slice($data2['data'], 0, 5) as $building) {
    echo "- {$building['name']} ({$building['city']}) - {$building['completion_year']}\n";
}
