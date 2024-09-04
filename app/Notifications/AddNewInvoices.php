<?php

namespace App\Notifications;

use App\Models\invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddNewInvoices extends Notification
{
    use Queueable;
    private $invoice;
    private $title; // Title property to store the notification title

    /**
     * Create a new notification instance.
     */
    public function __construct(invoice $invoice, $title)
    {
        $this->invoice = $invoice;
        $this->title = $title; // Store the title passed in the constructor
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->invoice->id,
            'title' => $this->title, // Use the title passed in the constructor
            'user' => Auth::user()->name,
        ];
    }
}
