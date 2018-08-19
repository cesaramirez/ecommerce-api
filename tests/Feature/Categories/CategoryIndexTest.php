<?php

namespace Tests\Feature\Categories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CategoryIndexTest extends TestCase
{
    /** @test */
    public function it_returns_a_collection_of_categories()
    {
        $categories = factory(Category::class, 2)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertStatus(200)
                     ->assertJsonFragment([
                        'slug' => $category->slug
                    ]);
        });
    }

    /** @test */
    public function it_returns_only_parent_categories()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            $subcategory = factory(Category::class)->create()
        );

        $response = $this->json('GET', 'api/categories');
        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function it_returns_categories_ordered_by_their_given_order()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $anotherCategory = factory(Category::class)->create([
            'order' => 1
        ]);

        $response = $this->json('GET', 'api/categories');
        $response->assertStatus(200)
                 ->assertSeeInOrder([
                    $anotherCategory->slug,
                    $category->slug
                 ]);
    }
}
