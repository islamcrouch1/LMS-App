<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class QueueRestartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:restartlms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Queue restart Command';

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
        Artisan::call('queue:restart');
    }
}
