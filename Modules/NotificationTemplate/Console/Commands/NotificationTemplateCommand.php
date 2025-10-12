<?php

namespace Modules\NotificationTemplate\Console\Commands;

use Illuminate\Console\Command;

class NotificationTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:NotificationTemplateCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'NotificationTemplate Command description';

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
