<?php

namespace Tests\Unit\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_title_is_required(): void
    {
        $validatedField = 'title';
        $brokenRule = null;

        $property = Property::factory()->make([$validatedField => $brokenRule]);

        $this->postJson(route('api.properties.store'), $property->toArray())
            ->assertJsonValidationErrors($validatedField);

        $existingProperty = Property::factory()->create();
        $newProperty = Property::factory()->make([$validatedField => $brokenRule]);

        $this->putJson(route('api.properties.update', $existingProperty), $newProperty->toArray())
            ->assertJsonValidationErrors($validatedField);
    }

    public function test_title_must_not_exceed_20_characters(): void
    {
        $validatedField = 'title';
        $brokenRule = str()->random(21);

        $property = Property::factory()->make([$validatedField => $brokenRule]);

        $this->postJson(route('api.properties.store'), $property->toArray())
            ->assertJsonValidationErrors($validatedField);
    }

    public function test_price_is_required(): void
    {
        $validatedField = 'price';
        $brokenRule = null;

        $property = Property::factory()->make([$validatedField => $brokenRule]);

        $this->postJson(route('api.properties.store'), $property->toArray())
            ->assertJsonValidationErrors($validatedField);
    }

    public function test_price_must_be_an_integer(): void
    {
        $validatedField = 'price';
        $brokenRule = 'not-integer';

        $property = Property::factory()->make([$validatedField => $brokenRule]);

        $this->postJson(route('api.properties.store'), $property->toArray())
            ->assertJsonValidationErrors($validatedField);
    }

    public function test_description_is_required(): void
    {
        $validatedField = 'description';
        $brokenRule = null;

        $property = Property::factory()->make([$validatedField => $brokenRule]);

        $this->postJson(route('api.properties.store'), $property->toArray())
            ->assertJsonValidationErrors($validatedField);
    }

    public function test_description_must_be_a_string(): void
    {
        $validatedField = 'description';
        $brokenRule = 235;

        $property = Property::factory()->make([$validatedField => $brokenRule]);

        $this->postJson(route('api.properties.store'), $property->toArray())
            ->assertJsonValidationErrors($validatedField);
    }
}
