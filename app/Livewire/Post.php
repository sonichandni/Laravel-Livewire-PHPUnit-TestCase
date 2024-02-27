<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Posts;

class Post extends Component
{
    public $posts, $title, $description, $postId, $updatePost = false, $addPost = false;

    #[Url] 
    public $search = '';

    /**
    * delete action listener
    */
    protected $listeners = [
        'deletePostListner' => 'deletePost'
    ];

    /**
    * List of add/edit form rules 
    */
    protected $rules = [
        'title' => 'required',
        'description' => 'required'
    ];

    /**
    * Reseting all inputted fields
    * @return void
    */
    public function resetFields() {
        $this->title = '';
        $this->description = '';
    }

    /**
    * render the post data
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    */
    public function render() {
        $temp_posts = Posts::select('id', 'title', 'description');

        if(!empty($this->search)) {
            $temp_posts->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
        }

        $temp_posts = $temp_posts->get();

        $this->posts = $temp_posts;
        return view('livewire.post');
    }

    /**
    * Open Add Post form
    * @return void
    */
    public function addNewPost() {
        $this->resetFields();
        $this->addPost = true;
        $this->updatePost = false;
    }

    /**
    * store the user inputted post data in the posts table
    * @return void
    */
    public function storePost() {
        $this->validate();
        Posts::create([
            'title' => $this->title,
            'description' => $this->description
        ]);
        session()->flash('success','Post Created Successfully!!');
        $this->resetFields();
        $this->addPost = false;
    }

    /**
    * show existing post data in edit post form
    * @param mixed $id
    * @return void
    */
    public function editPost($id) {
        $post = Posts::findOrFail($id);
        if(empty($post)) {
            session()->flash('error', 'Post not found!!');
        } else {
            $this->title = $post->title;
            $this->description = $post->description;
            $this->postId = $post->id;
            $this->addPost = false;
            $this->updatePost = true;
        }
    }

    /**
    * update the post data
    * @return void
    */
    public function updateOldPost() {
        $this->validate();
        Posts::find($this->postId)->update([
            'title' => $this->title,
            'description' => $this->description
        ]);
        session()->flash('success', 'Post Updated Successfully!!');
        $this->resetFields();
        $this->updatePost = false;
    }

    /**
    * Cancel Add/Edit form and redirect to post listing page
    * @return void
    */
    public function cancel() {
        $this->addPost = false;
        $this->updatePost = false;
        $this->resetFields();
    }

    /**
    * delete specific post data from the posts table
    * @param mixed $id
    * @return void
    */
    public function deletePost($id) {
        $post = Posts::findOrFail($id);
        if(empty($post)) {
            session()->flash('error', 'Post not found!!');
        } else {
            $post->delete();
            session()->flash('success', 'Post Deleted Successfully!!');
        }
    }
}
