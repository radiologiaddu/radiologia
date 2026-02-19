<?php
$db = new SQLite3(__DIR__ . '/database/database.sqlite');

echo "=== USUARIOS ===" . PHP_EOL;
$result = $db->query('SELECT * FROM users');
$hasUsers = false;
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $hasUsers = true;
    echo "ID: {$row['id']} | Email: {$row['email']} | Nombre: {$row['name']}" . PHP_EOL;
}
if (!$hasUsers) echo "No hay usuarios." . PHP_EOL;

echo PHP_EOL . "=== ROLES DISPONIBLES ===" . PHP_EOL;
$result = $db->query('SELECT * FROM roles');
$hasRoles = false;
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $hasRoles = true;
    echo "- {$row['name']}" . PHP_EOL;
}
if (!$hasRoles) echo "No hay roles definidos." . PHP_EOL;

echo PHP_EOL . "=== USUARIOS CON ROLES ASIGNADOS ===" . PHP_EOL;
$result = $db->query('SELECT u.email, r.name as role FROM users u JOIN model_has_roles mr ON u.id = mr.model_id JOIN roles r ON mr.role_id = r.id');
$hasAssignments = false;
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $hasAssignments = true;
    echo "{$row['email']} => {$row['role']}" . PHP_EOL;
}
if (!$hasAssignments) echo "Ningún usuario tiene roles asignados." . PHP_EOL;
