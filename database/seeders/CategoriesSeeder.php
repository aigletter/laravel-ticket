<?php

namespace Aigletter\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('ticket_categories')->exists()) {
            foreach ($this->getData() as $name => $label) {
                DB::table('ticket_categories')->insert([
                    'name' => $name,
                    'label' => $label,
                ]);
            }
        }
    }

    protected function getData()
    {
        return [
            'finance' => trans('Finance'),
            'error' => trans('Error'),
            'proposal' => trans('Proposal'),
            'complaint' => trans('Complaint'),
            'other' => trans('Other'),
        ];
    }
}
