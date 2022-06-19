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
        $minutes = intval($this->option('minutes'));

        $timeout = $minutes ? Carbon::now()->addMinutes($minutes)->getTimestamp() : 0;

        $status = $this->argument('status');

        Redis::set('envoyer_status', $status);
        Redis::set('envoyer_timeout', $timeout);

        $this->line('Status:  ' . $status);
        $this->line('Timeout: ' . $timeout);
        $this->line('Now:     ' . Carbon::now()->getTimestamp());
        $this->info('Done.');

        return 0;
    }
}
