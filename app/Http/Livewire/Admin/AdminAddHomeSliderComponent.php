<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminAddHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $status;

    public function mount()
    {
        $this->status = 0;
    }
    public function addSlide(){
        $slide = new HomeSlider();
        $slide->title =$this->title;
        $slide->subtitle =$this->subtitle;
        $slide->price =$this->price;
        $slide->link =$this->link;

        if ($this->image) {
            $ImageName = Carbon::now()->timestamp. '.' .$this->image->extension();
            $this->image->storeAs('sliders',$ImageName);
            $slide->image = $ImageName;
        }

        $slide->status =$this->status;
        $slide->save();
        session()->flash('message', 'Slide has been created successfully!');
    }

   

    public function render()
    {
        return view('livewire.admin.admin-add-home-slider-component')->layout('layouts.base');
    }
}
