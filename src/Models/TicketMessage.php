<?php


namespace Aigletter\Ticket\Models;


use Aigletter\LaravelAttachment\AttachmentTrait;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use AttachmentTrait;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'message',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}