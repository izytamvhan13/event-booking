<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingForwardedToPimpinan extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'event_name' => $this->booking->event_name,
            'booker_name' => $this->booking->user->name ?? '-',
            'message' => 'Booking "' . $this->booking->event_name . '" sudah disaring admin dan menunggu keputusan akhir Anda.',
        ];
    }
}