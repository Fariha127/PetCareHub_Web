<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use App\Models\VetCheckup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return match ($user->role) {
            'shelter_staff' => $this->staffDashboard(),
            'veterinarian' => $this->vetDashboard($user),
            default => $this->adopterDashboard($user),
        };
    }

    private function adopterDashboard($user): View
    {
        $applications = $user->adoptionApplications()
            ->with('pet')
            ->latest()
            ->get();

        $adoptedPetIds = $user->adoptionApplications()
            ->where('status', 'approved')
            ->pluck('pet_id');

        $checkupNotifications = VetCheckup::whereIn('pet_id', $adoptedPetIds)
            ->whereNotNull('next_checkup_date')
            ->where('next_checkup_done', false)
            ->with('pet')
            ->orderBy('next_checkup_date', 'asc')
            ->get();

        return view('dashboard.adopter', [
            'applications' => $applications,
            'totalApplications' => $applications->count(),
            'approvedCount' => $applications->where('status', 'approved')->count(),
            'pendingCount' => $applications->where('status', 'pending')->count(),
            'rejectedCount' => $applications->where('status', 'rejected')->count(),
            'availablePetsCount' => Pet::where('adoption_status', 'Available')->count(),
            'checkupNotifications' => $checkupNotifications,
        ]);
    }

    private function staffDashboard(): View
    {
        $applications = AdoptionApplication::with(['user', 'pet', 'reviewer'])
            ->latest()
            ->get();

        return view('dashboard.staff', [
            'applications' => $applications,
            'totalPets' => Pet::count(),
            'availablePets' => Pet::where('adoption_status', 'Available')->count(),
            'adoptedPets' => Pet::where('adoption_status', 'Adopted')->count(),
            'pendingApplications' => $applications->where('status', 'pending')->count(),
            'totalApplications' => $applications->count(),
        ]);
    }

    private function vetDashboard($user): View
    {
        $checkups = $user->vetCheckups()
            ->with('pet')
            ->latest('checkup_date')
            ->get();

        $upcomingCheckups = VetCheckup::with('pet')
            ->where('vet_id', $user->id)
            ->whereNotNull('next_checkup_date')
            ->where('next_checkup_date', '>=', now()->toDateString())
            ->orderBy('next_checkup_date')
            ->get();

        $pets = Pet::orderBy('name')->get();

        return view('dashboard.vet', [
            'checkups' => $checkups,
            'upcomingCheckups' => $upcomingCheckups,
            'totalCheckups' => $checkups->count(),
            'upcomingCount' => $upcomingCheckups->count(),
            'pets' => $pets,
        ]);
    }

    public function showProfile(Request $request): View
    {
        return view('dashboard.profile', [
            'user' => $request->user(),
        ]);
    }

    public function editProfile(Request $request): View
    {
        return view('dashboard.edit_profile', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:100'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        if (!$user->isShelterStaff()) {
            $user->occupation = $validated['occupation'];
        }

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully!');
    }

    public function requests(Request $request): View
    {
        $applications = $request->user()->adoptionApplications()
            ->with('pet')
            ->latest()
            ->get();

        return view('dashboard.my_requests', [
            'applications' => $applications,
        ]);
    }

    public function myPets(Request $request): View
    {
        $approvedApplications = $request->user()->adoptionApplications()
            ->where('status', 'approved')
            ->with('pet')
            ->get();

        $pets = $approvedApplications->pluck('pet')->filter();

        return view('dashboard.my_pets', [
            'pets' => $pets,
        ]);
    }

    public function viewUserProfile(User $user): View
    {
        $applications = $user->adoptionApplications()
            ->with('pet')
            ->latest()
            ->get();

        return view('dashboard.user_profile', [
            'user' => $user,
            'applications' => $applications,
        ]);
    }

    public function myEvents(Request $request): View
    {
        $participations = $request->user()->eventParticipations()
            ->with('event.creator')
            ->latest()
            ->get();

        return view('dashboard.my_events', [
            'participations' => $participations,
        ]);
    }

    public function myPosts(Request $request): View
    {
        $posts = $request->user()->helpPosts()
            ->with(['images', 'comments.user'])
            ->latest()
            ->get();

        return view('dashboard.my_posts', [
            'posts' => $posts,
        ]);
    }
}
