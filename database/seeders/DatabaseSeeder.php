<?php

namespace Database\Seeders;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use App\Models\VetCheckup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Demo Users ──
        $adopter = User::create([
            'name' => 'Alice Johnson',
            'email' => 'adopter@demo.com',
            'password' => bcrypt('password'),
            'role' => 'adopter',
            'phone' => '+1 (555) 234-5678',
            'address' => '123 Maple Street, Springfield',
            'occupation' => 'Graphic Designer',
        ]);

        $adopter2 = User::create([
            'name' => 'Bob Williams',
            'email' => 'adopter2@demo.com',
            'password' => bcrypt('password'),
            'role' => 'adopter',
            'phone' => '+1 (555) 876-5432',
            'address' => '456 Oak Avenue, Metropolis',
            'occupation' => 'Software Engineer',
        ]);

        $staff = User::create([
            'name' => 'Sarah Chen',
            'email' => 'staff@demo.com',
            'password' => bcrypt('password'),
            'role' => 'shelter_staff',
            'phone' => '+1 (555) 345-6789',
            'address' => '789 Pine Road, Riverdale',
            'occupation' => 'Shelter Coordinator',
        ]);

        $vet = User::create([
            'name' => 'Dr. James Miller',
            'email' => 'vet@demo.com',
            'password' => bcrypt('password'),
            'role' => 'veterinarian',
            'phone' => '+1 (555) 987-6543',
            'address' => '321 Elm Lane, Hill Valley',
            'occupation' => 'Doctor of Veterinary Medicine',
        ]);

        // ── Pets ──
        $milo = Pet::create([
            'name' => 'Milo',
            'species' => 'Cat',
            'breed' => 'Domestic Shorthair',
            'age' => 2,
            'gender' => 'Male',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=900&q=80',
            'description' => 'A calm indoor cat who enjoys sunny windows and gentle attention. Milo is perfect for a quiet household.',
        ]);

        $bella = Pet::create([
            'name' => 'Bella',
            'species' => 'Dog',
            'breed' => 'Labrador Mix',
            'age' => 4,
            'gender' => 'Female',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=80',
            'description' => 'Friendly, active, and ready for a family that enjoys daily walks and outdoor adventures.',
        ]);

        $rio = Pet::create([
            'name' => 'Rio',
            'species' => 'Bird',
            'breed' => 'Parakeet',
            'age' => 1,
            'gender' => 'Male',
            'vaccination_status' => 'Not Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=900&q=80',
            'description' => 'A bright, social parakeet suited for a quiet and attentive home.',
        ]);

        $luna = Pet::create([
            'name' => 'Luna',
            'species' => 'Cat',
            'breed' => 'Persian',
            'age' => 3,
            'gender' => 'Female',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Adopted',
            'image_url' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=900&q=80',
            'description' => 'Gentle and affectionate Persian cat who found her forever home.',
        ]);

        $max = Pet::create([
            'name' => 'Max',
            'species' => 'Dog',
            'breed' => 'German Shepherd',
            'age' => 5,
            'gender' => 'Male',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1589941013453-ec89f33b5e95?auto=format&fit=crop&w=900&q=80',
            'description' => 'Loyal and intelligent, Max is trained and great with older children.',
        ]);

        $daisy = Pet::create([
            'name' => 'Daisy',
            'species' => 'Dog',
            'breed' => 'Golden Retriever',
            'age' => 2,
            'gender' => 'Female',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1633722715463-d30f4f325e24?auto=format&fit=crop&w=900&q=80',
            'description' => 'A playful golden retriever who loves swimming and fetching.',
        ]);

        $whiskers = Pet::create([
            'name' => 'Whiskers',
            'species' => 'Cat',
            'breed' => 'Maine Coon',
            'age' => 4,
            'gender' => 'Male',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?auto=format&fit=crop&w=900&q=80',
            'description' => 'A majestic Maine Coon with a gentle temperament. Great with other cats.',
        ]);

        $coco = Pet::create([
            'name' => 'Coco',
            'species' => 'Rabbit',
            'breed' => 'Holland Lop',
            'age' => 1,
            'gender' => 'Female',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?auto=format&fit=crop&w=900&q=80',
            'description' => 'An adorable lop-eared rabbit who is litter-trained and loves cuddles.',
        ]);

        $rocky = Pet::create([
            'name' => 'Rocky',
            'species' => 'Dog',
            'breed' => 'Bulldog',
            'age' => 6,
            'gender' => 'Male',
            'vaccination_status' => 'Vaccinated',
            'adoption_status' => 'Adopted',
            'image_url' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=900&q=80',
            'description' => 'A lovable bulldog with a calm disposition who has found his family.',
        ]);

        $simba = Pet::create([
            'name' => 'Simba',
            'species' => 'Cat',
            'breed' => 'Bengal',
            'age' => 1,
            'gender' => 'Male',
            'vaccination_status' => 'Not Vaccinated',
            'adoption_status' => 'Available',
            'image_url' => 'https://images.unsplash.com/photo-1592194996308-7b43878e84a6?auto=format&fit=crop&w=900&q=80',
            'description' => 'An energetic Bengal kitten with beautiful markings. Very playful and curious.',
        ]);

        // ── Adoption Applications ──
        // Luna was adopted by Alice (approved)
        AdoptionApplication::create([
            'user_id' => $adopter->id,
            'pet_id' => $luna->id,
            'status' => 'approved',
            'message' => 'I have experience with Persian cats and a quiet apartment perfect for Luna.',
            'admin_notes' => 'Approved — great match for Luna\'s temperament.',
            'reviewed_by' => $staff->id,
            'reviewed_at' => now()->subDays(15),
            'created_at' => now()->subDays(20),
        ]);

        // Rocky was adopted by Bob (approved)
        AdoptionApplication::create([
            'user_id' => $adopter2->id,
            'pet_id' => $rocky->id,
            'status' => 'approved',
            'message' => 'I live in a house with a yard, perfect for Rocky.',
            'admin_notes' => 'Approved — suitable home environment.',
            'reviewed_by' => $staff->id,
            'reviewed_at' => now()->subDays(10),
            'created_at' => now()->subDays(14),
        ]);

        // Alice applied for Bella (pending)
        AdoptionApplication::create([
            'user_id' => $adopter->id,
            'pet_id' => $bella->id,
            'status' => 'pending',
            'message' => 'We have a large backyard and my kids would love a dog to play with!',
            'created_at' => now()->subDays(2),
        ]);

        // Bob applied for Milo (pending)
        AdoptionApplication::create([
            'user_id' => $adopter2->id,
            'pet_id' => $milo->id,
            'status' => 'pending',
            'message' => 'Looking for a calm indoor companion for my apartment.',
            'created_at' => now()->subDays(1),
        ]);

        // Alice applied for Daisy (rejected)
        AdoptionApplication::create([
            'user_id' => $adopter->id,
            'pet_id' => $daisy->id,
            'status' => 'rejected',
            'message' => 'Daisy looks perfect for our family.',
            'admin_notes' => 'Applicant already has a pending application. Please complete current adoption first.',
            'reviewed_by' => $staff->id,
            'reviewed_at' => now()->subDays(3),
            'created_at' => now()->subDays(5),
        ]);

        // ── Vet Checkups ──
        VetCheckup::create([
            'pet_id' => $milo->id,
            'vet_id' => $vet->id,
            'checkup_date' => now()->subDays(30),
            'weight' => 4.2,
            'temperature' => 38.5,
            'diagnosis' => 'Healthy — routine checkup',
            'treatment' => 'Annual vaccination administered',
            'next_checkup_date' => now()->addDays(335),
            'notes' => 'Milo is in great health. Continue current diet.',
        ]);

        VetCheckup::create([
            'pet_id' => $bella->id,
            'vet_id' => $vet->id,
            'checkup_date' => now()->subDays(14),
            'weight' => 28.5,
            'temperature' => 38.8,
            'diagnosis' => 'Minor skin irritation',
            'treatment' => 'Prescribed medicated shampoo, follow-up in 2 weeks',
            'next_checkup_date' => now()->addDays(1),
            'notes' => 'Skin irritation on left flank. Not serious but needs monitoring.',
        ]);

        VetCheckup::create([
            'pet_id' => $luna->id,
            'vet_id' => $vet->id,
            'checkup_date' => now()->subDays(25),
            'weight' => 3.8,
            'temperature' => 38.3,
            'diagnosis' => 'Healthy — pre-adoption checkup',
            'treatment' => 'None needed',
            'notes' => 'Luna is healthy and ready for her new home.',
        ]);

        VetCheckup::create([
            'pet_id' => $max->id,
            'vet_id' => $vet->id,
            'checkup_date' => now()->subDays(7),
            'weight' => 34.1,
            'temperature' => 38.6,
            'diagnosis' => 'Healthy — dental cleaning performed',
            'treatment' => 'Dental cleaning, tartar removal',
            'next_checkup_date' => now()->addMonths(6),
            'notes' => 'Teeth in good condition after cleaning.',
        ]);

        VetCheckup::create([
            'pet_id' => $coco->id,
            'vet_id' => $vet->id,
            'checkup_date' => now()->subDays(3),
            'weight' => 1.8,
            'temperature' => 39.0,
            'diagnosis' => 'Healthy — initial intake exam',
            'treatment' => 'Vaccination administered',
            'next_checkup_date' => now()->addDays(28),
            'notes' => 'New arrival, overall good health.',
        ]);
    }
}
