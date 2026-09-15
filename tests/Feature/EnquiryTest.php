<?php

namespace Tests\Feature;

use App\Enums\EnquiryStatus;
use App\Models\Tour;
use App\Models\TourEnquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;
    private function tour(): Tour
    {
        return Tour::create([
            'name' => 'Ha Long Bay Cruise',
            'slug' => 'ha-long-bay-cruise',
        ]);
    }

    public function test_status_sent_by_the_public_form_is_ignored(): void
    {
        $tour = $this->tour();

        $response = $this->postJson('/api/enquiries', [
            'tour_id' => $tour->id,
            'name' => 'Nam',
            'email' => 'nam@example.com',
            'status' => 'booked',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.status', 'new');

        $this->assertDatabaseHas('tour_enquiries', [
            'email' => 'nam@example.com',
            'status' => 'new',
        ]);
    }

    public function test_an_invalid_status_transition_is_rejected_and_leaves_the_record_unchanged(): void
    {
        $tour = $this->tour();

        $enquiry = new TourEnquiry([
            'tour_id' => $tour->id,
            'name' => 'Nam',
            'email' => 'nam@example.com',
        ]);
        $enquiry->status = EnquiryStatus::Booked;
        $enquiry->save();

        $response = $this->patchJson("/api/enquiries/{$enquiry->id}/status", [
            'status' => 'contacted',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('status');

        $this->assertSame(
            EnquiryStatus::Booked,
            $enquiry->fresh()->status,
        );
    }
}
