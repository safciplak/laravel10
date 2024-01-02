<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_products(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk();

        $response->assertJson([
            'data' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                ],
            ],
        ]);
    }

    public function test_can_store_a_product(): void
    {
        $product = Product::factory()->make();

        $response = $this->postJson(route('api.products.store'), $product->toArray());

        $response->assertCreated();

        $response->assertJson([
            'data'  => [
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
            ]
        ]);

        $this->assertDatabaseHas('products', $product->toArray());
    }

    public function test_can_get_show_product(): void
    {
        // Create an existing product using the factory
        $existingProduct = Product::factory()->create();

        // Use the 'show' route to retrieve the property
        $response = $this->getJson(route('api.products.show', $existingProduct->id));

        $response->assertOk();

        // Check the response JSON structure
        $response->assertJson([
            'data' => [
                'id' => $existingProduct->id,
                'name' => $existingProduct->name,
                'sku' => $existingProduct->sku,
                'price' => $existingProduct->price,
            ],
        ]);
    }

    public function test_can_update_a_product(): void
    {
        $existingProduct = Product::factory()->create();
        $newProduct = Product::factory()->make();

        $response = $this->putJson(route('api.products.update', $existingProduct), $newProduct->toArray());

        $response->assertJson([
            'data' => [
                'id' => $existingProduct->id,
                'name' => $newProduct->name,
                'sku' => $newProduct->sku,
                'price' => $newProduct->price,
            ]
        ]);

        $this->assertDatabaseHas('products', $newProduct->toArray());
    }

    public function test_can_delete_a_product(): void
    {
        $existingProduct = Product::factory()->create();

        $this->deleteJson(route('api.products.destroy', $existingProduct))
            ->assertNoContent();

        $this->assertDatabaseMissing(
            'products',
            $existingProduct->toArray()
        );
    }

}
