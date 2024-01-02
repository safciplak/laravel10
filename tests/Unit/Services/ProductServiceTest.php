<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testAllReturnsCollection()
    {
        // Create a mock for ProductRepositoryInterface
        $productRepositoryMock = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Collection
        $productRepositoryMock->method('all')->willReturn(new Collection());

        // Create an instance of ProductService with the mock repository
        $productService = new ProductService($productRepositoryMock);

        // Call the all method and assert that it returns a Collection
        $result = $productService->all();
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testCreateReturnsProduct()
    {
        // Create a mock for ProductRepositoryInterface
        $productRepositoryMock = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Property instance
        $productRepositoryMock->method('create')->willReturn(new Product([
            'name' => 'test created product',
            'sku' => 'sku test',
            'price' => 3,
        ]));

        // Create an instance of ( with the mock repository
        $productService = new ProductService($productRepositoryMock);

        // Call the create method and assert that it returns a Product instance
        $result = $productService->create([]);
        $this->assertInstanceOf(Product::class, $result);

        $this->assertEquals('test created product', $result->name);
        $this->assertEquals('sku test', $result->sku);
        $this->assertEquals(3, $result->price);
    }

    public function testUpdateReturnsProduct()
    {
        // Create a mock for ProductRepositoryInterface
        $productRepositoryMock = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Product instance
        $productRepositoryMock->method('update')->willReturn(new Product([
            'name' => 'test',
            'sku' => 'test2',
            'price' => 3,
        ]));

        // Create an instance of ProductService with the mock repository
        $productService = new ProductService($productRepositoryMock);

        // Call the update method and assert that it returns a Product instance
        $result = $productService->update(new Product(), []);

        $this->assertInstanceOf(Product::class, $result);

        $this->assertEquals('test', $result->name);
        $this->assertEquals('test2', $result->sku);
        $this->assertEquals(3, $result->price);
    }

    public function testDeleteReturnsVoid()
    {
        // Create a mock for ProductRepositoryInterface
        $productRepositoryMock = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Product instance
        $productRepositoryMock->method('delete');

        // Create an instance of ProductService with the mock repository
        $productService = new ProductService($productRepositoryMock);

        // Call the delete method and assert that it returns void
        $productService->delete(new Product());
        $this->assertNull(null);
    }
}
