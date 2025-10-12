<?php

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UserCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Command description';

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
