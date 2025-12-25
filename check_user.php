<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$name = "Ashiva";
$phone = "81558402888";

echo "--- SEARCH BY NAME ($name) ---\n";
$usersByName = \App\Models\User::where('name', 'LIKE', "%$name%")->get();
if ($usersByName->isEmpty()) {
    echo "No users found by name.\n";
}
foreach ($usersByName as $u) {
    echo "ID: $u->id | Name: $u->name | Phone: $u->phone | Role: $u->role\n";
}

echo "\n--- SEARCH BY PHONE ($phone) ---\n";
$usersByPhone = \App\Models\User::where('phone', 'LIKE', "%$phone%")->get();
if ($usersByPhone->isEmpty()) {
    echo "No users found by phone.\n";
}
foreach ($usersByPhone as $u) {
    echo "ID: $u->id | Name: $u->name | Phone: $u->phone | Role: $u->role\n";
}
