<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BathReminderController;

class SendDailyBathReminder extends Command
{
    protected $signature = 'bath:daily_reminder';
    protected $description = 'Envía un resumen diario de mascotas que necesitan baño';

    public function handle()
    {
        $controller = new BathReminderController();
        $controller->checkBathReminders();
        $this->info('📢 Recordatorio de baño enviado.');
    }
}
