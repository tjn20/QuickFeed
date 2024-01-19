<?php

namespace App\Livewire;

use Livewire\Component;

class ProfilePicture extends Component
{
    protected $listeners=['updatePic'];

    public $src;
    public $classes;

    public function mount($src,$classes)
    {
        $this->src=$src;
        $this->classes=$classes;
    }

    public function updatePic($data)
    {
        $this->src=asset('storage/'.$data);
    }
    public function render()
    {
        return view('livewire.profile-picture');
    }
}
