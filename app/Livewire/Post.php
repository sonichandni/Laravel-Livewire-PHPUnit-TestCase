<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Posts;

class Post extends Component
{
    public $posts, $title, $description, $postId, $updatePost = false, $addPost = false;

    /**
    * delete action listener
    */
    protected $listeners = [
        'deletePostListner' => 'deletePost'
    ];


    public function render()
    {
        return view('livewire.post');
    }
}
