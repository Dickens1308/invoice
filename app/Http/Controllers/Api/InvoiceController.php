<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\store\StoreInvoiceRequest;
use App\Http\Requests\update\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\InvoiceResource;
use App\Mail\InvoiceMail;
use App\Models\Supplier;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return InvoiceCollection
     */
    public function index(): InvoiceCollection
    {
        $invoices = Invoice::orderByDesc('updated_at')->paginate(10);

        return new InvoiceCollection($invoices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInvoiceRequest $request
     * @return Response|JsonResponse|InvoiceResource
     */
    public function store(StoreInvoiceRequest $request): Response|JsonResponse|InvoiceResource
    {
        try {
            $request->validated();

            $invoice = new Invoice();
            $invoice = $this->getInvoiceDTO($invoice, $request);

            //Check For Permissions From Policy Sets
            $response = Gate::inspect('create', $invoice);
            if (!$response->allowed())
                throw new Exception("Forbidden");


            if (!$invoice->save())
                throw new Exception("Failed to create invoice");

            $customer_id = 0;
            foreach ($request->orders as $order) {
                $orderDTO = new Order();
                $orderDTO->product_id = $order['product_id'];
                $orderDTO->customer_id = $order['customer_id'];
                $orderDTO->invoice_id = $invoice->id;
                $orderDTO->price = $order['price'];

                $customer_id = $order['customer_id'];

                //IF Order Failed To Save
                //Delete All Saved Order By Invoice ID
                if (!$orderDTO->save()) {
                    $invoice->forceDelete();
                    throw new Exception("Failed to save orders");
                }
            }

            $customer = Supplier::findorFail($customer_id);

            Mail::to($customer->email)
                ->cc('admin@shopify.com')
                ->bcc('manager@shopify.com')
                ->queue(new InvoiceMail($invoice, $customer));

            return new JsonResponse(array("invoice" => new InvoiceResource($invoice),
                'message' => "Successful created invoice"
            ), 201);

        } catch (Exception $throwable) {
            return new JsonResponse(array('message' =>
                $throwable->getMessage(),
                'time' => date_format(Carbon::now(), "Y-m-d H:i:s")), 403);
        }
    }

    /**
     * DTO - Data To Object Function.
     *
     * @param Invoice $invoice
     * @param $request
     * @return Invoice
     */
    private function getInvoiceDTO(Invoice $invoice, $request): Invoice
    {
        $invoice->invoice_no = $request->invoice_no;
        $invoice->items = $request->items;
        $invoice->tax = $request->tax;
        $invoice->total = $request->total;
        $invoice->sub_total = $request->sub_total;
        $invoice->discount = $request->discount;

        return $invoice;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInvoiceRequest $request
     * @param $id
     * @return Response|JsonResponse|InvoiceResource
     */
    public function update(UpdateInvoiceRequest $request, $id): Response|JsonResponse|InvoiceResource
    {
        try {
            $request->validated();

            if ($invoice = Invoice::findorFail($id)) {
                $response = Gate::inspect('update', $invoice);

                if ($response->allowed()) {
                    if ($invoice->update()) return new InvoiceResource($invoice); else
                        throw new Exception("Failed to update invoice");
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
            $invoice = Invoice::findorFail($id);

            $response = Gate::inspect('delete', $invoice);

            if (!$response->allowed())
                throw new Exception('Forbidden');

            if ($invoice->delete())
                return new JsonResponse(array('message' => "Successful deleted invoice",
                    'deleted_at' => date_format(Carbon::now(), "Y-m-d H:i:s")), 200);

        } catch (Exception $e) {
            if (str_contains($e->getMessage(), "No query results for model"))
                return new JsonResponse(array('message' => "Invoice not found in the storage",
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
                ), 404);

            return new JsonResponse(
                array('message' => $e->getMessage(),
                    'time' => date_format(Carbon::now(), "Y-m-d H:i:s")
                ), 403);
        }
    }
}
