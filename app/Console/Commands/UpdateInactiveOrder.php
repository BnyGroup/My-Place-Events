<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\OrderController;

class UpdateInactiveOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order status where order not done';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->order_controller = new OrderController;
        $this->order_controller->removeCancleOrder();
    }
}
