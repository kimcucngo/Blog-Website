<?php

namespace Tests\Feature\ControllerTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    //Test Add Post
    public function testAddPost()
    {
        $inputData = [
            'title' => 'jkhasjdfdsjkfdks',
            'body' => 'kjasdfkjdsjklfkldjns',
        ];
        $url = route('post.store');
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->post($url, $inputData);
        
        $response->assertRedirect(route('post.index'));
        $this->assertDatabaseHas('posts', $inputData);
    }

    //Test Update Post
    public function testUpdatePost()
    {
        $inputData = [
            'title' => 'ngothikimcuc1993',
            'body' => 'age:29 engineer'
        ];
        $url = route('post.store');
        $user = User::factory()->create();
        $this->actingAs($user)
                ->post($url,$inputData);
        $id = $user->posts->first()->id;
        print(Post::first());
        $editData = [
            'title' => 'phandinhloc1993',
            'body' => 'age:29 IT engineer'
        ];
        $response = $this->patch(route('post.update',$id),$editData);
        print(Post::first());
        $response->assertRedirect(route('post.index'));
        $this->assertDatabaseHas('posts',$editData);
    }

    //Test Create
    public function testCreate()
    {
        $url = route('post.create');
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->get($url);
        $response->assertStatus(200);
    }
    
    //Test Index
    public function testIndex()
    {
        $url = route('post.index');
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->get($url);
        $response->assertStatus(200);
    }
}