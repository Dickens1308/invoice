<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\store\StoreCustomerRequest;
use App\Http\Requests\update\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return CustomerCollection
     */
    public function index(Request $request): CustomerCollection
    {
        $pageSize = $request->input('size');
        $customers = Supplier::orderByDesc('updated_at')->paginate($pageSize);

        return new CustomerCollection($customers);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CustomerCollection
     */
    public function filter(Request $request): CustomerCollection
    {
        $pageSize = $request->input("size");
        $search = $request->input("search");

        if ($search == "male" || $search == "female") {
            $customers = Supplier::orderByDesc("updated_at")
                ->where('gender', $search)->paginate($pageSize);
        } else {
            $customers = Supplier::orderByDesc("updated_at")
                ->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('home_address', 'LIKE', '%' . $search . '%')
                ->paginate($pageSize);
        }

        return new CustomerCollection($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCustomerRequest $request
     * @return Response|CustomerResource|Application|ResponseFactory
     */
    public function store(StoreCustomerRequest $request): Response|CustomerResource|Application|ResponseFactory
    {
        try {
            $request->validated();

            $customer = new Supplier();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->phone_number = $request->phone_number;
            $customer->home_address = $request->home_address;
            $customer->gender = $request->gender;

            $response = Gate::inspect('create', $customer);

            if (!$response->allowed()) throw new Exception("Forbidden");

            if ($customer->save())
                return new JsonResponse(array(new CustomerResource($customer), 'message' => 'customer created successful'), 201);
            else
                throw new Exception("Failed to create customer");

        } catch (Exception $throwable) {
            return new JsonResponse(array('message' => $throwable->getMessage(),
                'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomerRequest $request
     * @param $id
     * @return Response|CustomerResource
     */
    public function update(UpdateCustomerRequest $request, $id): JsonResponse|CustomerResource
    {
        try {
            $request->validated();

            if ($customer = Supplier::findorFail($id)) {
                $customer->first_name = $request->first_name;
                $customer->last_name = $request->last_name;
                $customer->email = $request->email;
                $customer->phone_number = $request->phone_number;
                $customer->home_address = $request->home_address;
                $customer->gender = $request->gender;

                $response = Gate::inspect('update', $customer);

                if ($response->allowed()) {
                    if ($customer->update())
                        return new JsonResponse(array(new CustomerResource($customer),
                            'message' => "customer updated successful"),
                            Response::HTTP_CREATED);
                    else
                        throw new Exception("Failed to update customer");
                }

                throw new Exception('Permission denied');

            }
        } catch (Exception $exception) {
            if (str_contains($exception->getMessage(), "No query results for model"))
                return new JsonResponse(array('message' => "Customer not found in the storage",
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 400);

            if (str_contains($exception->getMessage(), "Permission denied"))
                return new JsonResponse(array('message' => $exception->getMessage(),
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 403);

            return new JsonResponse(array('message' => $exception->getMessage(),
                'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 500);
        }
    }

    /**
     * Delete the specified customer in storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $customer = Supplier::findorFail($id);

            $response = Gate::inspect('delete', $customer);

            if (!$response->allowed()) throw new Exception('Forbidden');

            if ($customer->delete()) return new JsonResponse(array('message' => "Successful deleted customer", 'deleted_at' => date_format(Carbon::now(), "Y-m-d H:i:s")), 200);

        } catch (Exception $e) {
            if (str_contains($e->getMessage(), "No query results for model")) return new JsonResponse(array('message' => "Customer not found in the storage", 'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 400);

            return new JsonResponse(array('message' => $e->getMessage(), 'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 403);
        }
    }
}
