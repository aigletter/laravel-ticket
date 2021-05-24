<?php


namespace Aigletter\Ticket;


use Aigletter\Ticket\Console\Commands\TicketInstall;
use Illuminate\Support\ServiceProvider;

class LaravelTicketServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LaravelTicket::class, function () {
            return new LaravelTicket();
        });
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TicketInstall::class,
            ]);
        }
    }
}