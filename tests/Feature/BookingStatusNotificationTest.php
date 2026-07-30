<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingStatusNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_status_change_notifies_the_booking_owner(): void
    {
        $owner = User::factory()->create([
            'name' => 'Pemilik Booking',
            'email' => 'owner@example.com',
            'role' => 'user',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $venue = Venue::create([
            'name' => 'Ruang Serbaguna',
            'capacity' => 100,
            'description' => 'Ruang rapat premium',
        ]);

        $booking = Booking::create([
            'user_id' => $owner->id,
            'venue_id' => $venue->id,
            'event_name' => 'Rapat Internal',
            'start_time' => now()->addDay()->setTime(9, 0),
            'end_time' => now()->addDay()->setTime(11, 0),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->put(route('bookings.update', $booking), [
            'status' => 'approved',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $owner->id,
            'notifiable_type' => User::class,
        ]);

        $notification = $owner->fresh()->notifications()->latest()->first();
        $this->assertSame('approved', $notification->data['status']);
        $this->assertSame($booking->id, $notification->data['booking_id']);
        $this->assertStringContainsString('disetujui', $notification->data['message']);
    }
}
