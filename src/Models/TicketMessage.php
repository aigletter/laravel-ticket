<?php


namespace Aigletter\Ticket\Models;


use Aigletter\LaravelAttachment\AttachmentTrait;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use AttachmentTrait;

    public const STATUS_UNREAD = 0;

    public const STATUS_READ = 1;

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
