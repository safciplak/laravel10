<?php

namespace App\Services;

use App\Models\Property;
use App\Repositories\PropertyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PropertyService implements PropertyRepositoryInterface
{
    private PropertyRepositoryInterface $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function all(): Collection
    {
        return $this->propertyRepository->all();
    }

    public function show(Property $property): Property
    {
        return $this->propertyRepository->show($property);
    }

    public function create(array $data): Property
    {
        return $this->propertyRepository->create($data);
    }

    public function update(Property $property, array $data): Property
    {
        return $this->propertyRepository->update($property, $data);
    }

    public function delete(Property $property): void
    {
        $this->propertyRepository->delete($property);
    }
}
