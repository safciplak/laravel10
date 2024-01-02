<?php

namespace Tests\Feature\Api;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_properties(): void
    {
        $property = Property::factory()->create();

        $response = $this->getJson(route('api.properties.index'));

        $response->assertOk();

        $response->assertJson([
            'data' => [
                [
                    'id' => $property->id,
                    'title' => $property->title,
                    'description' => $property->description,
                    'price' => $property->price,
                ],
            ],
        ]);
    }

    public function test_can_store_a_property(): void
    {
        $property = Property::factory()->make();

        $response = $this->postJson(route('api.properties.store'), $property->toArray());

        $response->assertCreated();

        $response->assertJson([
            'data'  => [
                'title' => $property->title,
                'description' => $property->description,
                'price' => $property->price,
            ]
        ]);

        $this->assertDatabaseHas('properties', $property->toArray());
    }

    public function test_can_get_show_property(): void
    {
        // Create an existing property using the factory
        $existingProperty = Property::factory()->create();

        // Use the 'show' route to retrieve the property
        $response = $this->getJson(route('api.properties.show', $existingProperty->id));

        $response->assertOk();

        // Check the response JSON structure
        $response->assertJson([
            'data' => [
                'id' => $existingProperty->id,
                'title' => $existingProperty->title,
                'description' => $existingProperty->description,
                'price' => $existingProperty->price,
                // Add other fields as needed
            ],
        ]);
    }

    public function test_can_update_a_property(): void
    {
        $existingProperty = Property::factory()->create();
        $newProperty = Property::factory()->make();

        $response = $this->putJson(route('api.properties.update', $existingProperty), $newProperty->toArray());

        $response->assertJson([
            'data' => [
                'id' => $existingProperty->id,
                'title' => $newProperty->title,
            ]
        ]);

        $this->assertDatabaseHas('properties', $newProperty->toArray());
    }

    public function test_can_delete_a_property(): void
    {
        $existingProperty = Property::factory()->create();

        $this->deleteJson(route('api.properties.destroy', $existingProperty))
        ->assertNoContent();

        $this->assertDatabaseMissing(
            'properties',
            $existingProperty->toArray()
        );
    }
}
