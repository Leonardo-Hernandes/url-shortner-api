<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ClearAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearAnalytics:cron';

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
        DB::table('analytics')->truncate(); // pega os e-mails
        // siga o código de sua preferencia
        // executando as funções de envio de e-mail
        $this->info('Analytics cleared');
    }
}
