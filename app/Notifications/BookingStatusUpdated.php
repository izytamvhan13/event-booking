<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking, public string $status)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $statusLabel = match ($this->status) {
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            default => 'diperbarui',
        };

        $message = 'Booking "' . $this->booking->event_name . '" ' . $statusLabel . '.';

        if ($this->status === 'rejected' && !empty($this->booking->rejection_reason)) {
            $message .= ' Alasan: ' . $this->booking->rejection_reason;
        }

        return [
            'booking_id' => $this->booking->id,
            'event_name' => $this->booking->event_name,
            'status' => $this->status,
            'message' => $message,
        ];
    }
}
