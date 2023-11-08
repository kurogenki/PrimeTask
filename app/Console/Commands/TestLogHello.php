<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestLogHello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TestLogHello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ログにHELLOと出力';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("HELLO");
    }
}
