<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Access the database
try {
    $user = new \App\Models\User();
    $user->name = 'Admin User';
    $user->email = 'admin@radiologia.local';
    $user->password = bcrypt('password123');
    $user->save();
    
    echo "✅ Usuario admin creado:\n";
    echo "   Email: admin@radiologia.local\n";
    echo "   Password: password123\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
