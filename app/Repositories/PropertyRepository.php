<?php

namespace App\Repositories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function all(): Collection
    {
        return Property::latest()->get();
    }

    public function show(Property $property): Property
    {
        return $property->find($property->id);
    }

    public function create(array $data): Property
    {
        return Property::create($data);
    }

    public function update(Property $property, array $data): Property
    {
        $property->update($data);

        return $property;
    }

    public function delete(Property $property): void
    {
        $property->delete();
    }
}
