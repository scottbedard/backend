<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class EnvoyerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:envoyer {status} {--minutes=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Envoyer deployment values';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $minutes = Carbon::now()->addMinutes(intval($this->option('minutes')))->getTimestamp();

        Redis::set('envoyer_status', $this->argument('status'));
        Redis::set('envoyer_timeout', $minutes);

        $this->info('Done.');

        return 0;
    }
}
