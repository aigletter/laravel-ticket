<?php


namespace Aigletter\Ticket\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function status()
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @todo move user model to config
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}