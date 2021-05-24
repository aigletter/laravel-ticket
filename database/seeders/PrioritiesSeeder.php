<?php

namespace Aigletter\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('ticket_priorities')->exists()) {
            foreach ($this->getData() as $name => $label) {
                DB::table('ticket_priorities')->insert([
                    'name' => $name,
                    'label' => $label,
                ]);
            }
        }
    }

    protected function getData()
    {
        return [
            'low' => trans('Low'),
            'medium' => trans('Medium'),
            'high' => trans('High'),
        ];
    }
}
