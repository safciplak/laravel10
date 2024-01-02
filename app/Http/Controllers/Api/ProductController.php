<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\PropertyResource;
use App\Models\Product;
use App\Models\Property;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $data = $this->productService->all();

        $data = ProductResource::collection($data);
        return response()->json([
            'data' => $data
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        $data = $this->productService->show($product);

        //$data = new PropertyResource($data);
        return response()->json([
            'data' => $data,
        ], Response::HTTP_OK);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $this->productService->create($request->all());

        return response()->json([
            'data' => $data,
        ], Response::HTTP_CREATED);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $data = $this->productService->update($product, $request->all());

        $data = new ProductResource($data);
        return response()->json([
            'data' => $data
        ]);
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return response([], Response::HTTP_NO_CONTENT);
    }
}
