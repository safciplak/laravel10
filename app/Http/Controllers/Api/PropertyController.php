<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    private PropertyService $propertyService;

    /**
     * @param PropertyService $propertyService
     */
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function index(): JsonResponse
    {
        $data = $this->propertyService->all();

        $data = PropertyResource::collection($data);
        return response()->json([
            'data' => $data
        ]);
    }

    public function show(Property $property): JsonResponse
    {
        $data = $this->propertyService->show($property);

        $data = new PropertyResource($data);
        return response()->json([
            'data' => $data,
        ], Response::HTTP_OK);
    }

    public function store(PropertyRequest $request): JsonResponse
    {
        $data = $this->propertyService->create($request->all());

        $data = new PropertyResource($data);
        return response()->json([
            'data' => $data,
        ], Response::HTTP_CREATED);
    }

    public function update(PropertyRequest $request, Property $property): JsonResponse
    {
        $data = $this->propertyService->update($property, $request->all());

        $data = new PropertyResource($data);
        return response()->json([
            'data' => $data
        ]);
    }

    public function destroy(Property $property)
    {
        $this->propertyService->delete($property);

        return response([], Response::HTTP_NO_CONTENT);
    }
}
