<?php


namespace Aigletter\Ticket\Models;


class TicketCategory extends \Illuminate\Database\Eloquent\Model
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}