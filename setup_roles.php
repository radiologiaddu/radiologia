<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use App\Models\User;

$roles = [
    'Administrador',
    'Doctor',
    'Recepcion',
    'Hostess',
    'Caja',
    'Coordinador',
    'Radiologo'
];

echo "=== CREANDO ROLES ===" . PHP_EOL;
foreach ($roles as $roleName) {
    $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
    echo "✓ Rol creado: {$roleName}" . PHP_EOL;
}

echo PHP_EOL . "=== ASIGNANDO ROL ADMINISTRADOR AL USUARIO 1 ===" . PHP_EOL;

// Obtener usuario directamente sin SoftDeletes
$db = new SQLite3(__DIR__ . '/database/database.sqlite');
$result = $db->query('SELECT id, email FROM users WHERE id = 1');
$userData = $result->fetchArray(SQLITE3_ASSOC);

if ($userData) {
    // Insertar en model_has_roles directamente
    $roleResult = $db->query("SELECT id FROM roles WHERE name = 'Administrador'");
    $roleData = $roleResult->fetchArray(SQLITE3_ASSOC);
    
    if ($roleData) {
        $db->exec("INSERT OR IGNORE INTO model_has_roles (role_id, model_type, model_id) VALUES ({$roleData['id']}, 'App\\\\Models\\\\User', {$userData['id']})");
        echo "✓ Rol 'Administrador' asignado a: {$userData['email']}" . PHP_EOL;
    }
}

echo PHP_EOL . "=== USUARIOS CON ROLES ===" . PHP_EOL;
$result = $db->query('SELECT u.email, r.name as role FROM users u JOIN model_has_roles mr ON u.id = mr.model_id JOIN roles r ON mr.role_id = r.id');
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "{$row['email']} => {$row['role']}" . PHP_EOL;
}

echo PHP_EOL . "¡Listo! Puedes iniciar sesión con:" . PHP_EOL;
echo "Email: admin@radiologia.local" . PHP_EOL;
echo "Password: password123" . PHP_EOL;
