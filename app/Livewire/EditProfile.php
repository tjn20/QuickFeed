<?php

namespace App\Livewire;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;


    public $bio;

    public $profileImg;

    public function mount()
    {
        $this->bio=Auth::user()->bio;
    }



    public function saveChanges()
    {
        $authUser=Auth::user();

        $authUser->update([
            'bio'=>$this->bio
        ]);
        if($this->profileImg)
        {
            if($authUser->image)
            unlink('storage/'.$authUser->image->image_path);

            $imgName = time() . '_' . $this->profileImg->getClientOriginalName();

           
            $this->profileImg->storeAs('public',$imgName);
        
           if($authUser->image)
            Image::where('imageable_id',$authUser->id)
            ->update([
                'image_path'=>$imgName
            ]);
            else
            $authUser->image()->create([
            'image_path'=>$imgName
            ]);

            $this->dispatch('updatePic',$imgName);


        }
        $this->dispatch('showAlert',
        ['message'=>"Edit was successful",
        'icon'=>"<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>"
         ]);
         

        $this->skipRender();
    }
    public function render()
    {
        return view('livewire.edit-profile');
    }
}
