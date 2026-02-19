<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== USUARIOS EN EL SISTEMA ===" . PHP_EOL . PHP_EOL;

$users = \App\Models\User::all();
if ($users->isEmpty()) {
    echo "No hay usuarios registrados." . PHP_EOL;
} else {
    foreach ($users as $user) {
        $roles = $user->roles->pluck('name')->implode(', ') ?: 'Sin roles';
        echo "ID: {$user->id}" . PHP_EOL;
        echo "  Email: {$user->email}" . PHP_EOL;
        echo "  Nombre: {$user->name}" . PHP_EOL;
        echo "  Roles: {$roles}" . PHP_EOL;
        echo PHP_EOL;
    }
}

echo "=== ROLES DISPONIBLES ===" . PHP_EOL;
$roles = \Spatie\Permission\Models\Role::all();
if ($roles->isEmpty()) {
    echo "No hay roles definidos." . PHP_EOL;
} else {
    foreach ($roles as $role) {
        echo "- {$role->name}" . PHP_EOL;
    }
}
