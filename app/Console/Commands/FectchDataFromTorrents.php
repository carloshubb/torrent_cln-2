<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
class FectchDataFromTorrents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fectch-data-from-torrents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Scheduled task ran at ' . now());
    }
}
