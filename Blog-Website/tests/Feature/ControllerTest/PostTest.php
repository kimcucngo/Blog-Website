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
    public function testEditPost()
    {
        $inputData = [
            'title' => 'jkhasjdfdsjkfdks',
            'body' => 'kjasdfkjdsjklfkldjns',
        ];
        $url = route('post.store');
        $user = User::factory()->create();
        $this->actingAs($user)
                ->post($url, $inputData);
        $id = $user->posts->first()->id;
        $editData = [
            'title' => '21321321421432',
            'body' => '21321321421432',
        ];
        $response = $this->patch(route('post.update',$id), $editData);
        $response->assertRedirect(route('post.index'));
        $this->assertDatabaseHas('posts', $editData);

    }
    public function testCreate()
    {
        $url = route('post.create');
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->get($url);
        $response->assertStatus(200);
    }
    public function testIndex()
    {
        $url = route('post.index');
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->get($url);
        $response->assertStatus(200);
    }
}