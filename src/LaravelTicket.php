<?php


namespace Aigletter\Ticket;


use Aigletter\Ticket\Models\Ticket;
use Aigletter\Ticket\Models\TicketCategory;
use Aigletter\Ticket\Models\TicketPriority;
use Aigletter\Ticket\Models\TicketStatus;
use App\Models\User;

class LaravelTicket
{
    public function getUserTickets($userId)
    {
        $user = User::query()->where('id', $userId)->first();
        $tickets = $user->tickets()->with('messages')->get();

        return $tickets;
    }

    public function getTicket($tiketId)
    {
        $ticket = Ticket::query()->with(['category', 'priority', 'user', 'status', 'messages'])->first();

        return $ticket;
    }

    public function addTicket(
        $userId,
        $categoryId,
        $priorityId,
        $subject
    ) {
        $ticket = new Ticket();
        $ticket->user_id = $userId;
        $ticket->category_id = $categoryId;
        $ticket->priority_id = $priorityId;
        $ticket->subject = $subject;
        // TODO
        $ticket->status_id = TicketStatus::query()->first()->id;
        $ticket->save();
    }

    public function getCategories()
    {
        return TicketCategory::query()->get();
    }

    public function getStatuses()
    {
        return TicketStatus::query()->get();
    }

    public function getPriorities()
    {
        return TicketPriority::query()->get();
    }
}