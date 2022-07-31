<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserEditProfileComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $mobile;
    public $image;
    public $linel;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipcode;
    public $newimage;

    public function mount()
{
    $user = User::find (Auth::user()->id);
    $this->name = $user->name;
    $this->email = $user->email;
    $this->mobile= $user->profile->mobile;
    $this->image = $user->profile->image;
    $this->line1 = $user->profile->linel;
    $this->line2= $user->profile->line2;
    $this->city = $user->profile->city;
    $this->province = $user->profile->province;
    $this->country = $user->profile->name;
    $this->zipcode = $user->profile->name;
}




public function updateProfile()
{
    
    $user = User::find(Auth::user()->id);
    $user->name = $this->name;
    $user->save();

    if($this->newimage){
        if($this->image){
            unlink("assets/images/profile/".$this->image);
        }
        $imageName= Carbon::now()->timestamp.'.'. $this->newimage->extension();
        $this->newimage->storeAs('profile', $imageName);
        $user->profile->image = $imageName;
    }
    $user->profile->mobile = $this->mobile;
    $user->profile->linel = $this->linel;
    $user->profile->line2 = $this->line2;
    $user->profile->city = $this->city;
    $user->profile->province = $this->province;
    $user->profile->country =  $this->country;
    $user->profile->zipcode = $this->zipcode;
    $user->profile->save();
    session()->flash("message", "Profile has been updated successfully!");
}
    public function render()
    {
        return view('livewire.user.user-edit-profile-component')->layout('layouts.base');
    }
}
