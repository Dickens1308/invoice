<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\store\StorePurchasereturnRequest;
use App\Http\Requests\update\UpdatePurchasereturnRequest;
use App\Models\Purchasereturn;

class PurchasereturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\store\StorePurchasereturnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchasereturnRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchasereturn  $purchasereturn
     * @return \Illuminate\Http\Response
     */
    public function show(Purchasereturn $purchasereturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchasereturn  $purchasereturn
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchasereturn $purchasereturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\update\UpdatePurchasereturnRequest  $request
     * @param  \App\Models\Purchasereturn  $purchasereturn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchasereturnRequest $request, Purchasereturn $purchasereturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchasereturn  $purchasereturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchasereturn $purchasereturn)
    {
        //
    }
}
