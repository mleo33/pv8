<?php

namespace App\Console\Commands;

use App\Models\Producto;
use Illuminate\Console\Command;

class ProductFactoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a fake products for testing purposes';

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
     * @return int
     */
    public function handle()
    {
        Producto::factory(200)->create();
        return 0;
    }
}
