<?php

namespace Tests\Unit\Models\Categories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_has_many_children()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $category->children->first());
    }

    /** @test */
    public function it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->assertEquals(1, $category->parents()->count());
    }

    /** @test */
    public function it_is_orderable_by_a_numbered_order()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);
        $anotherCategory = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->assertEquals($anotherCategory->name, Category::ordered()->first()->name);
    }
}
