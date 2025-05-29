<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testCreatedComment()
    {
        $comment = new Comment();
        $comment->email = 'hans@gmail.com';
        $comment->title = 'sample title';
        $comment->comment = 'sammple comment';

        $comment->save();

        $this->assertNotNull($comment->id);
    }
}
