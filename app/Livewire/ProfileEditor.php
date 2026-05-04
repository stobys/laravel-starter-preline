<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class ProfileEditor extends Component
{
    use WithFileUploads;

    // User fields
    #[Rule('required|string|max:255')]
    public $first_name;

    #[Rule('required|string|max:255')]
    public $last_name;

    #[Rule('required|string|email|max:255|unique:users,email')]
    public $email;

    // Profile fields
    #[Rule('nullable|string|max:1000')]
    public $bio;

    public $isProfileInfoModal = false;
    public $isProfileAddressModal = false;

    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->bio = $user->profile->bio ?? '';
    }

    public function updateProfile()
    {
        // $validated = $this->validate();

        $user = Auth::user();

        // -- Update user
        $user->update([
            'first_name' => $this->first_name, // $validated['first_name'],
            'last_name' => $this->last_name, // $validated['last_name'],
            'email' => $this->email, // $validated['email'],
        ]);

        // -- Update profile
        $user->profile()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'bio' => $this->bio // $validated['bio']
        ]);

        session()->flash('message', 'Profile updated successfully!');

        $this -> isProfileInfoModal = false;
        $this -> isProfileAddressModal = false;
    }

    public function render()
    {
        return view('livewire.user-profile')->layout('layout.flowbite.app');
    }
}
