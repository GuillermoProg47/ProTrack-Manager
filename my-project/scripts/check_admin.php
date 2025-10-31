<?php
$vendor = __DIR__ . '/../vendor/autoload.php';
if (! file_exists($vendor)) {
    echo "vendor autoload not found\n";
    exit(1);
}
require $vendor;
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\User;
$u = User::where('email', 'admin@example.com')->first();
if ($u) {
    echo "FOUND: " . $u->email . " (role=" . ($u->role ?? 'user') . ")\n";
} else {
    echo "NOT FOUND\n";
}
