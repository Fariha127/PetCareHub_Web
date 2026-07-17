<?php

namespace Tests\Feature;

use App\Models\AdoptionApplication;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $adopter;
    protected User $vet;
    protected User $staff;
    protected Pet $pet;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles users
        $this->adopter = User::factory()->create(['role' => 'adopter']);
        $this->vet = User::factory()->create(['role' => 'veterinarian']);
        $this->staff = User::factory()->create(['role' => 'shelter_staff']);

        // Create a pet
        $this->pet = Pet::create([
            'name' => 'Charlie',
            'species' => 'Dog',
            'breed' => 'Labrador',
            'age' => 2,
            'gender' => 'Male',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'description' => 'A friendly dog.',
        ]);
    }

    /**
     * Guest is redirected.
     */
    public function test_guests_cannot_access_appointments(): void
    {
        $response = $this->get(route('dashboard.appointments.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Adopter can list and view booking page.
     */
    public function test_adopters_can_access_appointments_pages(): void
    {
        $response = $this->actingAs($this->adopter)->get(route('dashboard.appointments.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->adopter)->get(route('dashboard.appointments.create'));
        $response->assertStatus(200);
    }

    /**
     * Adopter can book appointment for adopted pet.
     */
    public function test_adopter_can_book_appointment_for_adopted_pet(): void
    {
        // Approve adoption application first
        AdoptionApplication::create([
            'user_id' => $this->adopter->id,
            'pet_id' => $this->pet->id,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->adopter)->post(route('dashboard.appointments.store'), [
            'pet_id' => $this->pet->id,
            'vet_id' => $this->vet->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'reason' => 'Routine rabies vaccine checkup',
        ]);

        $response->assertRedirect(route('dashboard.appointments.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'user_id' => $this->adopter->id,
            'pet_id' => $this->pet->id,
            'vet_id' => $this->vet->id,
            'status' => 'pending',
            'reason' => 'Routine rabies vaccine checkup',
        ]);
    }

    /**
     * Adopter cannot book appointment for unadopted pet.
     */
    public function test_adopter_cannot_book_appointment_for_unadopted_pet(): void
    {
        // Application is pending (not approved)
        AdoptionApplication::create([
            'user_id' => $this->adopter->id,
            'pet_id' => $this->pet->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->adopter)->post(route('dashboard.appointments.store'), [
            'pet_id' => $this->pet->id,
            'vet_id' => $this->vet->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'reason' => 'Should fail',
        ]);

        $response->assertSessionHasErrors('pet_id');
        $this->assertDatabaseMissing('appointments', [
            'reason' => 'Should fail',
        ]);
    }

    /**
     * Adopter can cancel a pending appointment.
     */
    public function test_adopter_can_cancel_pending_appointment(): void
    {
        $appointment = Appointment::create([
            'user_id' => $this->adopter->id,
            'pet_id' => $this->pet->id,
            'vet_id' => $this->vet->id,
            'appointment_date' => now()->addDays(2),
            'reason' => 'Routine check',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->adopter)->post(route('dashboard.appointments.cancel', $appointment));
        $response->assertSessionHas('success');

        $this->assertEquals('cancelled', $appointment->fresh()->status);
    }

    /**
     * Veterinarian can view and manage their appointments.
     */
    public function test_veterinarian_can_approve_reject_and_complete_appointments(): void
    {
        $appointment = Appointment::create([
            'user_id' => $this->adopter->id,
            'pet_id' => $this->pet->id,
            'vet_id' => $this->vet->id,
            'appointment_date' => now()->addDays(2),
            'reason' => 'Routine check',
            'status' => 'pending',
        ]);

        // Vet accesses list
        $response = $this->actingAs($this->vet)->get(route('dashboard.appointments.vet-index'));
        $response->assertStatus(200);

        // Vet approves
        $response = $this->actingAs($this->vet)->post(route('dashboard.appointments.vet-approve', $appointment));
        $response->assertSessionHas('success');
        $this->assertEquals('approved', $appointment->fresh()->status);

        // Vet completes
        $response = $this->actingAs($this->vet)->post(route('dashboard.appointments.vet-complete', $appointment));
        $response->assertSessionHas('success');
        $this->assertEquals('completed', $appointment->fresh()->status);
    }

    /**
     * Vet rejects appointment.
     */
    public function test_veterinarian_can_reject_appointments(): void
    {
        $appointment = Appointment::create([
            'user_id' => $this->adopter->id,
            'pet_id' => $this->pet->id,
            'vet_id' => $this->vet->id,
            'appointment_date' => now()->addDays(2),
            'reason' => 'Routine check',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->vet)->post(route('dashboard.appointments.vet-reject', $appointment));
        $response->assertSessionHas('success');
        $this->assertEquals('rejected', $appointment->fresh()->status);
    }
}
