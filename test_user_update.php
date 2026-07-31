<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$u = App\Models\User::first();
try {
    $u->update(['name' => 'Testing Update']);
    echo "SUCCESS: " . $u->name;
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
