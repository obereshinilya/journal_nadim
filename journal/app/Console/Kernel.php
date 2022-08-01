<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
    protected function schedule(Schedule $schedule)
    {

        $schedule->call('App\Http\Controllers\TestController@test',['params_type'=>1])->cron('40 0-23 * * *');
        $schedule->call('App\Http\Controllers\TestController@test',['params_type'=>5])->cron('*/5 0-23 * * *');
        $schedule->call('App\Http\Controllers\TestController@test',['params_type'=>24])->cron('0 10 * * *');
        $schedule->call('App\Http\Controllers\XMLController@create_xml',['hours_xml'=>5])->cron('1,6,11,16,21,26,31,36 0-23 * * *');
        $schedule->call('App\Http\Controllers\XMLController@create_xml',['hours_xml'=>1])->cron('1 0,2,4,6,8,10,12,14,16,18,20,22 * * *');
        $schedule->call('App\Http\Controllers\XMLController@create_xml',['hours_xml'=>24])->cron('1 10 * * *');
        $schedule->call('App\Http\Controllers\TestController@create_record_rezhim_dks')->cron('1 0,4,8,12,16,20 * * *');
        $schedule->call('App\Http\Controllers\BalansController@create_record_svodniy')->cron('59 * * * *');
        $schedule->call('App\Http\Controllers\BalansController@create_record_valoviy')->cron('59 * * * *');
//        $schedule->call('App\Http\Controllers\TestTableController@record_plan')->cron('*/2 * * * *');




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
