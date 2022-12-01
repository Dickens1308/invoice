<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\store\StoreCategoryRequest;
use App\Http\Requests\update\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
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
        $category = Category::orderByDesc('updated_at')->get();

        return CategoryResource::collection($category);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return CategoryResource|JsonResponse
     */
    public function store(StoreCategoryRequest $request): CategoryResource|JsonResponse
    {
        try {
            $request->validated();

            $category = new Category();
            $category->name = $request->name;

            $response = Gate::inspect('create', $category);

            if (!$response->allowed())
                throw new Exception("Forbidden");

            if ($category->save())
                return new CategoryResource($category);
            else
                throw new Exception("Failed to create category");

        } catch (Exception $throwable) {
            return new JsonResponse(array('message' =>
                $throwable->getMessage(), 'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 403);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param $id
     * @return CategoryResource|Response|JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id): CategoryResource|Response|JsonResponse
    {
        try {
            $request->validated();

            if ($category = Category::findorFail($id)) {
                $category->name = $request->name;

                $response = Gate::inspect('update', $category);

                if ($response->allowed()) {
                    if ($category->update()) return new CategoryResource($category); else
                        throw new Exception("Failed to update category name");
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
            $category = Category::findorFail($id);

            $response = Gate::inspect('delete', $category);

            if (!$response->allowed())
                throw new Exception('Forbidden');

            if ($category->delete())
                return new JsonResponse(array('message' => "Successful deleted category",
                    'deleted_at' => date_format(Carbon::now(), "Y-m-d H:i:s")), 200);

        } catch (Exception $e) {
            if (str_contains($e->getMessage(), "No query results for model"))
                return new JsonResponse(array('message' => "Category not found in the storage",
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
                ), 404);

            return new JsonResponse(
                array('message' => $e->getMessage(),
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
                ), 403);
        }
    }
}
