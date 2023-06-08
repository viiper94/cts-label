<?php

namespace App\Console;

use App\EmailingQueue;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){

        // handling emails
        $schedule->call(function(){
            EmailingQueue::send();
        })->everyMinute();

        // handling backups
        $schedule->command('backup:run')->daily()->at('01:00')->when(function(){
            return DB::table('audits')->whereDate('created_at', Carbon::yesterday())->count() > 0;
        });
        $schedule->command('backup:clean')->daily()->at('01:30')->when(function(){
            return DB::table('audits')->whereDate('created_at', Carbon::yesterday())->count() > 0;
        });

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
