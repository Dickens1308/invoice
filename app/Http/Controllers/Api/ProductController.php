<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\store\StoreProductRequest;
use App\Http\Requests\update\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $product = Product::orderByDesc('updated_at')->get();

        return ProductResource::collection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return ProductResource|Response|JsonResponse
     */
    public function store(StoreProductRequest $request): ProductResource|Response|JsonResponse
    {
        try {
            $request->validated();

            $product = new Product();
            $product = $this->getProduct($product, $request, 'store');

            $response = Gate::inspect('create', $product);

            if (!$response->allowed())
                throw new Exception("Forbidden");

            if ($product->save())
                return new ProductResource($product);
            else
                throw new Exception("Failed to create product");

        } catch (Exception $throwable) {
            return new JsonResponse(array('message' =>
                $throwable->getMessage(), 'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 403);
        }
    }

    private function getProduct(Product $product, $request, $method): Product
    {
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->brand = $request->brand;
        $product->description = $request->description;
        $product->category_id = $request->category_id;

        $product->barcode = $method == "store" ? Str::orderedUuid() : $request->barcode;

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param $id
     * @return Response|JsonResponse|ProductResource
     */
    public function update(UpdateProductRequest $request, $id): Response|JsonResponse|ProductResource
    {
        try {
            $request->validated();

            if ($product = Product::findorFail($id)) {
                $productDTO = $this->getProduct($product, $request, 'update');
                $response = Gate::inspect('update', $product);

                if ($response->allowed()) {
                    if ($productDTO->update()) return new ProductResource($productDTO); else
                        throw new Exception("Failed to update product");
                }

                throw new Exception('Forbidden');

            }
        } catch (Exception $exception) {
            return new JsonResponse(array('message' => $exception->getMessage(),
                'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
            ), 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response|JsonResponse
     */
    public function destroy($id): Response|JsonResponse
    {
        try {
            $product = Product::findorFail($id);

            $response = Gate::inspect('delete', $product);

            if (!$response->allowed())
                throw new Exception('Forbidden');

            if ($product->delete())
                return new JsonResponse(array('message' => "Successful deleted product",
                    'deleted_at' => date_format(Carbon::now(), "Y-m-d H:i:s")), 200);

        } catch (Exception $e) {
            if (str_contains($e->getMessage(), "No query results for model"))
                return new JsonResponse(array('message' => "Product not found in the storage",
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
                ), 404);

            return new JsonResponse(
                array('message' => $e->getMessage(),
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
                ), 403);
        }
    }
}
