<?php
// Diagnóstico de Laravel
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "=== DIAGNOSTICO LARAVEL ===\n\n";

// 1. Autoload
try {
    require __DIR__ . '/vendor/autoload.php';
    echo "[OK] Autoload cargado\n";
} catch (Exception $e) {
    die("[ERROR] Autoload: " . $e->getMessage() . "\n");
}

// 2. Bootstrap App
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "[OK] App bootstrap\n";
} catch (Exception $e) {
    die("[ERROR] Bootstrap: " . $e->getMessage() . "\n");
}

// 3. Kernel
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "[OK] Kernel creado\n";
} catch (Exception $e) {
    die("[ERROR] Kernel: " . $e->getMessage() . "\n");
}

// 4. Database connection
try {
    $connection = $app->make('db')->connection();
    $connection->getPdo();
    echo "[OK] Conexión a BD\n";
} catch (Exception $e) {
    echo "[ERROR] BD: " . $e->getMessage() . "\n";
}

// 5. Simular request
try {
    $request = Illuminate\Http\Request::capture();
    echo "[OK] Request capturada\n";
    
    $response = $kernel->handle($request);
    echo "[OK] Response generada - Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() >= 500) {
        echo "\n=== CONTENIDO RESPONSE ===\n";
        echo substr($response->getContent(), 0, 2000);
    }
} catch (Exception $e) {
    echo "[ERROR] Request: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}
