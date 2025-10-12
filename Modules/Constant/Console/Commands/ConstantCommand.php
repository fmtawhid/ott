<?php

namespace Modules\Constant\Console\Commands;

use Illuminate\Console\Command;

class ConstantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ConstantCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Constant Command description';

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
