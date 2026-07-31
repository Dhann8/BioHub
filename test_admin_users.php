<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/admin/users', 'GET');
$user = App\Models\User::where('role', 'admin')->first();
$app['auth']->guard()->setUser($user);
$request->setUserResolver(function() use ($user) { return $user; });
$response = $kernel->handle($request);
echo $response->status() . "\n";
if ($response->status() != 200) {
    echo substr(strip_tags($response->getContent()), 0, 1000);
}
