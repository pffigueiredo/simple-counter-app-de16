<?php

namespace Tests\Feature;

use App\Models\Counter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_counter_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                 ->has('count')
        );
    }

    public function test_counter_starts_at_zero_when_no_counter_exists(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                 ->where('count', 0)
        );
    }

    public function test_counter_increments_when_button_clicked(): void
    {
        // Create initial counter
        Counter::create(['count' => 5]);

        $response = $this->post('/counter');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                 ->where('count', 6)
        );

        $this->assertDatabaseHas('counters', [
            'count' => 6
        ]);
    }

    public function test_counter_creates_new_record_if_none_exists(): void
    {
        $this->assertDatabaseCount('counters', 0);

        $response = $this->post('/counter');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                 ->where('count', 1)
        );

        $this->assertDatabaseCount('counters', 1);
        $this->assertDatabaseHas('counters', [
            'count' => 1
        ]);
    }

    public function test_counter_value_persists_across_requests(): void
    {
        // Increment counter multiple times
        $this->post('/counter');
        $this->post('/counter');
        $this->post('/counter');

        // Check that value persists
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('welcome')
                 ->where('count', 3)
        );
    }
}