<?php

namespace Modules\Currency\Console\Commands;

use Illuminate\Console\Command;

class CurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CurrencyCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Currency Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
