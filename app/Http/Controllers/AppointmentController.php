<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments for adopters.
     */
    public function index(Request $request): View
    {
        $appointments = $request->user()->appointments()
            ->with(['pet', 'vet'])
            ->latest('appointment_date')
            ->get();

        return view('dashboard.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for booking a new appointment.
     */
    public function create(Request $request): View
    {
        // Get the pets owned/adopted by this user
        $approvedApplications = $request->user()->adoptionApplications()
            ->where('status', 'approved')
            ->with('pet')
            ->get();

        $pets = $approvedApplications->pluck('pet')->filter();

        // Get all registered veterinarians
        $vets = User::where('role', 'veterinarian')->get();

        return view('dashboard.appointments.create', compact('pets', 'vets'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pet_id' => ['required', 'exists:pets,id'],
            'vet_id' => ['required', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'max:2000'],
        ]);

        // Validate the vet is actually a vet
        $vet = User::find($validated['vet_id']);
        if (!$vet || !$vet->isVet()) {
            return back()->withErrors(['vet_id' => 'The selected user is not registered as a veterinarian.'])->withInput();
        }

        // Validate the adopter owns/adopted this pet
        $ownsPet = $request->user()->adoptionApplications()
            ->where('pet_id', $validated['pet_id'])
            ->where('status', 'approved')
            ->exists();

        if (!$ownsPet) {
            return back()->withErrors(['pet_id' => 'You can only book appointments for your adopted pets.'])->withInput();
        }

        Appointment::create([
            'user_id' => $request->user()->id,
            'pet_id' => $validated['pet_id'],
            'vet_id' => $validated['vet_id'],
            'appointment_date' => $validated['appointment_date'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard.appointments.index')->with('success', 'Your appointment has been booked successfully and is pending approval from the veterinarian.');
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($appointment->status, ['pending', 'approved'])) {
            return back()->with('error', 'Only pending or approved appointments can be cancelled.');
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Appointment has been cancelled successfully.');
    }

    /**
     * Display a listing of appointments for veterinarians.
     */
    public function vetIndex(Request $request): View
    {
        $appointments = $request->user()->vetAppointments()
            ->with(['pet', 'user'])
            ->latest('appointment_date')
            ->get();

        return view('dashboard.appointments.vet_index', compact('appointments'));
    }

    /**
     * Approve an appointment (Veterinarians).
     */
    public function vetApprove(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->vet_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$appointment->isPending()) {
            return back()->with('error', 'This appointment is not pending.');
        }

        $appointment->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Appointment has been approved.');
    }

    /**
     * Reject an appointment (Veterinarians).
     */
    public function vetReject(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->vet_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$appointment->isPending()) {
            return back()->with('error', 'This appointment is not pending.');
        }

        $appointment->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Appointment has been rejected.');
    }

    /**
     * Complete an appointment (Veterinarians).
     */
    public function vetComplete(Request $request, Appointment $appointment): RedirectResponse
    {
        if ($appointment->vet_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$appointment->isApproved()) {
            return back()->with('error', 'Only approved appointments can be marked as completed.');
        }

        $appointment->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Appointment has been marked as completed.');
    }
}
