<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    /** @test */
    public function it_fails_if_a_product_cant_be_found()
    {
        $this->json('GET', 'api/products/none')
             ->assertStatus(404);
    }

    /** @test */
    public function it_shows_a_product()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', "api/products/{$product->slug}")
             ->assertJsonFragment([
                 'id' => $product->id,
             ]);
    }
}
