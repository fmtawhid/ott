<?php

namespace Modules\World\Console\Commands;

use Illuminate\Console\Command;

class WorldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:WorldCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'World Command description';

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
