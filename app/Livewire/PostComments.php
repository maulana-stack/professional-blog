<?php

namespace App\Livewire;

use App\Models\{Post, Comment};
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;
    public string $name = '';
    public string $email = '';
    public string $content = '';

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'content' => 'required|min:10',
    ];

    public function submit()
    {
        $this->validate();

        Comment::create([
            'post_id' => $this->post->id,
            'name' => $this->name,
            'email' => $this->email,
            'content' => $this->content,
            'approved' => false,
        ]);

        $this->reset('name', 'email', 'content');
        session()->flash('success', 'Comment posted! It will appear after moderation.');
    }

    public function render()
    {
        return view('livewire.post-comments');
    }
}
