<?php

namespace App\Console;

use App\Jobs\ScheduleEntryDispatcherJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new \App\Jobs\ScreenStatusCheckJob())->everyMinute();
        $schedule->job(new ScheduleEntryDispatcherJob())->everyMinute();

        if (config('app.default_project') === "EF27") {
            $schedule->job(new \App\Jobs\SyncEurofurenceScheduleJob())->everyMinute();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
