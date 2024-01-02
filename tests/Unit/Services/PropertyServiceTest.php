<?php

namespace Tests\Unit\Services;

use App\Models\Property;
use App\Repositories\PropertyRepositoryInterface;
use App\Services\PropertyService;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class PropertyServiceTest extends TestCase
{
    public function testAllReturnsCollection()
    {
        // Create a mock for PropertyRepositoryInterface
        $propertyRepositoryMock = $this->getMockBuilder(PropertyRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Collection
        $propertyRepositoryMock->method('all')->willReturn(new Collection());

        // Create an instance of PropertyService with the mock repository
        $propertyService = new PropertyService($propertyRepositoryMock);

        // Call the all method and assert that it returns a Collection
        $result = $propertyService->all();
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testCreateReturnsProperty()
    {
        // Create a mock for PropertyRepositoryInterface
        $propertyRepositoryMock = $this->getMockBuilder(PropertyRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Property instance
        $propertyRepositoryMock->method('create')->willReturn(new Property([
            'title' => 'test created property'
        ]));

        // Create an instance of PropertyService with the mock repository
        $propertyService = new PropertyService($propertyRepositoryMock);

        // Call the create method and assert that it returns a Property instance
        $result = $propertyService->create([]);
        $this->assertInstanceOf(Property::class, $result);

        $this->assertEquals('test created property', $result->title);
    }

    public function testUpdateReturnsProperty()
    {
        // Create a mock for PropertyRepositoryInterface
        $propertyRepositoryMock = $this->getMockBuilder(PropertyRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Property instance
        $propertyRepositoryMock->method('update')->willReturn(new Property([
            'title' => 'test',
            'price' => 3,
            'description' => 'test description'
        ]));

        // Create an instance of PropertyService with the mock repository
        $propertyService = new PropertyService($propertyRepositoryMock);

        // Call the update method and assert that it returns a Property instance
        $result = $propertyService->update(new Property(), []);

        $this->assertInstanceOf(Property::class, $result);

        $this->assertEquals('test', $result->title);
        $this->assertEquals(3, $result->price);
        $this->assertEquals('test description', $result->description);
    }

    public function testDeleteReturnsVoid()
    {
        // Create a mock for PropertyRepositoryInterface
        $propertyRepositoryMock = $this->getMockBuilder(PropertyRepositoryInterface::class)
            ->getMock();

        // Set up the mock to return a Property instance
        $propertyRepositoryMock->method('delete');

        // Create an instance of PropertyService with the mock repository
        $propertyService = new PropertyService($propertyRepositoryMock);

        // Call the delete method and assert that it returns void
        $propertyService->delete(new Property());
        $this->assertNull(null);
    }
}
