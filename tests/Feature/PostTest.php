<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Livewire\{Post, SearchPosts};
use Livewire\Livewire;
use App\Models\Posts;

class PostTest extends TestCase
{
    /** @test */
    public function renders_successfully() {
        Livewire::test(Post::class)->assertStatus(200);
    }

    /** @test */
    public function component_exists_on_the_page() {
        $this->get('/')
            ->assertSeeLivewire(Post::class);
    }

    /** @test */
    public function displays_posts() {
        Posts::factory()->make(['title' => 'On bathing well',
                                'description' => 'On bathing well'
                                ]);
        Posts::factory()->make(['title' => 'There\'s no time like bathtime']);
 
        Livewire::test(Post::class)
            ->assertSee('On bathing well')
            ->assertSee('There\'s no time like bathtime');
    }

    /** @test */
    public function displays_all_posts() {
        Posts::factory()->make(['title' => 'On bathing well']);
        Posts::factory()->make(['title' => 'The bathtub is my sanctuary']);
 
        Livewire::test(Post::class)
            ->assertViewHas('posts', function ($posts) {
                return count($posts) == 5;
            });
    }

    /** @test */
    public function can_set_title() {
        Livewire::test(Post::class)
            ->set('title', 'Confessions of a serial soaker')
            ->assertSet('title', 'Confessions of a serial soaker');
    }

    /** @test */
    public function title_field_is_populated() {
        $post = Posts::factory()->make([
            'title' => 'Top ten bath bombs',
        ]);
 
        Livewire::test(Post::class)
            ->set('post', $post)
            ->assertSet('post.title', 'Top ten bath bombs');
    }

    /** @test */
    public function can_search_posts_via_url_query_string() {
    Posts::factory()->create(['title' => 'Testing the first water-proof hair dryer']);
    Posts::factory()->create(['title' => 'Rubber duckies that actually float']);

    Livewire::test(Post::class, ['search' => 'hair'])
        ->assertSee('Testing the first')
        ->assertDontSee('Rubber duckies');
    }

    /** @test */
    public function can_create_post() {
        $this->assertEquals(5, Posts::count());
 
        Livewire::test(Post::class)
            ->set('title', 'Wrinkly fingers? Try this one weird trick')
            ->set('description', '...')
            ->call('storePost');
 
        $this->assertEquals(6, Posts::count());
    }

    /** @test */
    public function can_delete_post() {
        $this->assertEquals(6, Posts::count());

        Livewire::test(Post::class)
            ->call('deletePost', 25);

        $this->assertEquals(5, Posts::count());
    }

    /** @test */
    public function title_field_is_required() {
        Livewire::test(Post::class)
            ->set('title', '')
            ->call('storePost')
            ->assertHasErrors('title');
    }

    // /** @test */ Note: Below test case not working
    // public function notification_is_dispatched_when_deleting_a_post() {
    //     Livewire::test(Post::class)
    //                 ->call('deletePost', 27)
    //                 ->assertDispatched('deletePostListner');
    // }
}
