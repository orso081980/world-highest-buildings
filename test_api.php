<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the API controller directly
$controller = new App\Http\Controllers\Api\BuildingController();
$request = new Illuminate\Http\Request();
$request->merge(['per_page' => 5]);

$response = $controller->index($request);
$data = json_decode($response->getContent(), true);

echo "API Test Results:\n";
echo "================\n";
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
echo "Total buildings: " . $data['pagination']['total'] . "\n";
echo "Current page: " . $data['pagination']['current_page'] . "\n";
echo "Per page: " . $data['pagination']['per_page'] . "\n";
echo "Last page: " . $data['pagination']['last_page'] . "\n";
echo "Has more pages: " . ($data['pagination']['has_more_pages'] ? 'Yes' : 'No') . "\n";
echo "\nFirst 3 buildings:\n";
foreach (array_slice($data['data'], 0, 3) as $building) {
    echo "- {$building['name']} ({$building['city']}) - {$building['height']}\n";
}
