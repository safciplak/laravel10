<?php

namespace Tests\Unit\Repositories;

use App\Models\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $propertyRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->propertyRepository = app(PropertyRepository::class);
    }

    /** @test */
    public function it_can_get_all_properties()
    {
        $properties = Property::factory(3)->create();

        $allProperties = $this->propertyRepository->all();

        $this->assertCount(3, $allProperties);
        $this->assertEquals($properties->pluck('id')->toArray(), $allProperties->pluck('id')->toArray());
    }

    /** @test */
    public function it_can_create_a_property()
    {
        $propertyData = [
            'title' => 'Test Property',
            'price' => 100000,
            'description' => 'Test Property description',
        ];

        $property = $this->propertyRepository->create($propertyData);

        $this->assertInstanceOf(Property::class, $property);
        $this->assertEquals($propertyData['title'], $property->title);
        $this->assertEquals($propertyData['price'], $property->price);
        $this->assertEquals($propertyData['description'], $property->description);
    }

    /** @test */
    public function it_can_update_a_property()
    {
        $property = Property::factory()->create();

        $newData = [
            'title' => 'Updated Property',
            'price' => 150000,
        ];

        $updatedProperty = $this->propertyRepository->update($property, $newData);

        $this->assertInstanceOf(Property::class, $updatedProperty);
        $this->assertEquals($newData['title'], $updatedProperty->title);
        $this->assertEquals($newData['price'], $updatedProperty->price);
    }

    /** @test */
    public function it_can_delete_a_property()
    {
        $property = Property::factory()->create();

        $this->propertyRepository->delete($property);

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }
}
