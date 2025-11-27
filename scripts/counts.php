<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ExamApproval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$pendingApprovals = ExamApproval::where('status', 'pending')->count();

$unreadNotifications = 0;
if (Schema::hasTable('notifications')) {
    if (Schema::hasColumn('notifications', 'read_at')) {
        $unreadNotifications = DB::table('notifications')->whereNull('read_at')->count();
    } elseif (Schema::hasColumn('notifications', 'status')) {
        $unreadNotifications = DB::table('notifications')->where('status', 'unread')->count();
    } else {
        // fallback: count all notifications
        $unreadNotifications = DB::table('notifications')->count();
    }
}

echo "pending_approvals:" . $pendingApprovals . PHP_EOL;
echo "unread_notifications:" . $unreadNotifications . PHP_EOL;
