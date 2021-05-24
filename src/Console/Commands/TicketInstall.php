<?php

namespace Aigletter\Ticket\Console\Commands;

use Aigletter\Ticket\Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;

class TicketInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install ticket system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate', [
            '--realpath' => realpath(__DIR__ . '/../../../database/migrations')
        ]);

        $class = DatabaseSeeder::class;
        $this->call('db:seed', [
            '--class' => $class
        ]);

        return 0;
    }
}
