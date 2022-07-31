<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminEditHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $slider_id;
    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $image;
    public $newimage;
    public $status;

    public function mount($slide_id)
    { 
        $slide = HomeSlider::find($slide_id);
        $this->title = $slide->title;
        $this->subtitle = $slide->subtitle;
        $this->price = $slide->price;
        $this->link = $slide->link;
        $this->image = $slide->image;
        $this->status = $slide->status;
        $this->slider_id = $slide->id;
    }
    public function editSlide(){
        $slide = HomeSlider::find($this->slider_id);
        $slide->title =$this->title;
        $slide->subtitle =$this->subtitle;
        $slide->price =$this->price;
        $slide->link =$this->link;

        if ($this->newimage) {
            $ImageName = Carbon::now()->timestamp. '.' .$this->newimage->extension();
             $this->newimage->storeAs('sliders',$ImageName);
             $slide->image = $ImageName;
        }
       

        $slide->status =$this->status;
        $slide->save();
        session()->flash('message', 'Slide has been updated successfully!');
    }
    public function render()
    {
        $slides = HomeSlider::all();
        return view('livewire.admin.admin-edit-home-slider-component',['slides'=>$slides])->layout('layouts.base');
    }
}
