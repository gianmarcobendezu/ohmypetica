<?php


use Illuminate\Support\Facades\Artisan;

Artisan::command('bath:daily_reminder')->dailyAt('08:00');
