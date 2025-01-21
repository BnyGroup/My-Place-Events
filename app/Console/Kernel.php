<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Booking;
use Carbon\Carbon;
use App\Http\Controllers\Admin\OrderController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\UpdateInactiveOrder',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('order:update')->everyMinute();
        // $schedule->call(function () {
        //     $this->regularise_by_cron();
        // })->everyMinute();
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

    public function regularise_by_cron(){
        $regularise = 0;
        $compteur = 0;
        $orders_id = '';
        $datacount = new Booking;
        $orderController = new OrderController;
        foreach($datacount->getDataforDashThree() as $key => $val){
            if($val->delivred_status == 0 && Carbon::parse($val->created_at)->addMinutes(20) < Carbon::now() && !in_array($val->order_status, [4,5])){
                $orders_id .=$val->order_id.'-';
                $compteur++;
            }
            else if ($val->delivred_status == 0 && Carbon::parse($val->created_at)->addMinutes(30) < Carbon::now() && $val->order_status == 5) {
                $orders_id .=$val->order_id.'-';
                $compteur++;
            }
        }
        if($compteur > 0){
            $orderController->regularise($orders_id);
        }
    }

}
