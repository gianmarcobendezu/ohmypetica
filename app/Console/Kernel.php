<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Definir los comandos de Artisan para la aplicación.
     */
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
        //$schedule->command('bath:daily_reminder')->dailyAt('08:00');
    }
}