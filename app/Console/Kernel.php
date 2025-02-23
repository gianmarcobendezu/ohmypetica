<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Definir los comandos de Artisan para la aplicación.
     */

     protected $commands = [
        //        'App\Console\Commands\HelpCenter',
                Commands\SendDailyBathReminder::class
            ];

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Definir la programación de tareas.
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejecutar el recordatorio de baños diariamente a las 8 AM
        $schedule->command('bath:daily_reminder')->everyThreeMinutes();	
        $schedule->call(function () {
            Log::info('Test');
        })->everyMinute();
    }
}