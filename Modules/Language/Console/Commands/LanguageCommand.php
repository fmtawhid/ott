<?php

namespace Modules\Language\Console\Commands;

use Illuminate\Console\Command;

class LanguageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LanguageCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Language Command description';

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
