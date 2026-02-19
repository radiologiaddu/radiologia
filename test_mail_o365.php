<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Prueba de correo desde radiologia app.ddu.mx - ' . date('Y-m-d H:i:s'), function($message) {
        $message->to('alejandro@longevai.com')
                ->subject('Test SMTP Office365');
    });
    echo "Email enviado correctamente\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
