<?php

namespace Tests\Unit\Repositories;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $productRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = app(ProductRepository::class);
    }

    /** @test */
    public function it_can_get_all_properties()
    {
        $products = Product::factory(3)->create();

        $allProducts = $this->productRepository->all();

        $this->assertCount(3, $allProducts);
        $this->assertEquals($products->pluck('id')->toArray(), $allProducts->pluck('id')->toArray());
    }

    /** @test */
    public function it_can_create_a_products()
    {
        $productData = [
            'name' => 'Test Product',
            'price' => 100000,
            'sku' => 'Test SKU ',
        ];

        $product = $this->productRepository->create($productData);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($productData['name'], $product->name);
        $this->assertEquals($productData['sku'], $product->sku);
        $this->assertEquals($productData['price'], $product->price);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $newData = [
            'name' => 'Updated Product',
            'sku' => 'Updated Sku',
            'price' => 150000,
        ];

        $updatedProduct = $this->productRepository->update($product, $newData);

        $this->assertInstanceOf(Product::class, $updatedProduct);
        $this->assertEquals($newData['name'], $updatedProduct->name);
        $this->assertEquals($newData['sku'], $updatedProduct->sku);
        $this->assertEquals($newData['price'], $updatedProduct->price);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $this->productRepository->delete($product);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
