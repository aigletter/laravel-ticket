<?php


namespace Aigletter\Ticket;


use Aigletter\LaravelAttachment\LaravelAttachment;
use Aigletter\Ticket\Models\Ticket;
use Aigletter\Ticket\Models\TicketCategory;
use Aigletter\Ticket\Models\TicketMessage;
use Aigletter\Ticket\Models\TicketPriority;
use Aigletter\Ticket\Models\TicketStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaravelTicket
{
    /**
     * @param $user
     * @param null $filters
     * @return mixed
     *
     * @todo make filters as object
     * @todo add user model to config
     */
    public function getUserTickets($user, $filters = [])
    {
        if ($user instanceof Model) {
            $user = $user->id;
        }

        $query = Ticket::query()
            ->with('messages')
            ->withCount(['messages' => function (Builder $builder) use ($user) {
                $builder->where('user_id', '!=', $user)
                    ->where('status', TicketMessage::STATUS_UNREAD);
            }])->where('user_id', $user);
        if ($filters) {
            foreach ($filters as $key => $value) {
                $query->where($key, $value);
            }
        }

        $tickets = $query->get();

        return $tickets;
    }

    public function getTicket($ticketId)
    {
        $ticket = Ticket::query()
            ->with([
                'category',
                'priority',
                'user',
                'status',
                'messages',
                'messages',
                'messages.attachments',
                'attachments'
            ])
            ->where('id', $ticketId)
            ->first();

        return $ticket;
    }

    public function addTicket(
        int $userId,
        int $categoryId,
        int $priorityId,
        string $subject,
        string $content,
        ?\SplFileInfo $file = null
    ) {
        DB::beginTransaction();
        try {
            $ticket = new Ticket();
            $ticket->user_id = $userId;
            $ticket->category_id = $categoryId;
            $ticket->priority_id = $priorityId;
            $ticket->subject = $subject;
            $ticket->content = $content;
            // TODO
            $ticket->status_id = TicketStatus::query()->first()->id;
            $ticket->save();

            if ($file) {
                /** @var LaravelAttachment $attachments */
                $attachments  = app(LaravelAttachment::class);
                $attachments->attach($ticket, 'file', $file);
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function addMessage(
        $ticket,
        string $content,
        ?\SplFileInfo $file = null
    ) {
        if (is_int($ticket)) {
            $ticket = $this->getTicket($ticket);
            if (!$ticket) {
                throw new \Exception('Ticket not found');
            }
        }

        DB::beginTransaction();
        try {
            $message = new TicketMessage();
            $message->ticket_id = $ticket->id;
            $message->user_id = auth()->id();
            $message->message = $content;
            $message->save();

            if ($file) {
                /** @var LaravelAttachment $attachments */
                $attachments  = app(LaravelAttachment::class);
                $attachments->attach($message, 'file', $file);
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function changeMessageStatus($message, $status)
    {
        if (is_numeric($message)) {
            $message = $this->getTicket($message);
            if (!$message) {
                throw new \Exception('Ticket not found');
            }
        }

        $message->status = $status;

        return $message->save();
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
