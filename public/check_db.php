<?php
// Load Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// We just want to run some code, not return the full app response yet.
// Actually, using the bootstrapped app to query DB is enough.
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "<pre>";
echo "<h1>Database Connection Check (Web)</h1>";
echo "Default Connection: " . config('database.default') . "\n";
echo "Database: " . config('database.connections.' . config('database.default') . '.database') . "\n";
echo "Host: " . config('database.connections.' . config('database.default') . '.host') . "\n";
echo "Port: " . config('database.connections.' . config('database.default') . '.port') . "\n";

echo "\n<h2>User Count Check</h2>";
$users = User::all();
echo "Total Users found: " . $users->count() . "\n";
foreach($users as $u) {
    echo "ID: " . $u->id . " | Name: " . $u->name . " | Phone: " . $u->phone . "\n";
}

echo "\n<h2>Searching for 'Ashiva'</h2>";
$ashiva = User::where('name', 'LIKE', '%Ashiva%')->orWhere('phone', 'LIKE', '%81558402888%')->get();
if ($ashiva->isEmpty()) {
    echo "Result: NOT FOUND in this database.\n";
} else {
    echo "Result: FOUND! ID: " . $ashiva->first()->id . "\n";
}

echo "</pre>";
