<?php

namespace Aigletter\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('ticket_statuses')->exists()) {
            foreach ($this->getData() as $name => $label) {
                DB::table('ticket_statuses')->insert([
                    'name' => $name,
                    'label' => $label,
                ]);
            }
        }
    }

    protected function getData()
    {
        return [
            'open' => trans('Open'),
            'closed' => trans('Closed'),
        ];
    }
}
