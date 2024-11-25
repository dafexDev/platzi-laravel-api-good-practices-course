<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory(2)->create();

        $response = $this->getJson('/api/categories');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => ['name']
                    ]
                ]
            ]);
    }

    public function test_show()
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $response = $this->getJson('/api/categories/' . $category->id);
        $response->assertStatus(Response::HTTP_OK) // 200
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'attributes' => ['name']
                ]
            ]);
    }
}
