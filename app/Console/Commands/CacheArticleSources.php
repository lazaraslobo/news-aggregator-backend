<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheArticleSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cached-articles';

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
        \Log::info("My first cron job is running!");
    }
}
