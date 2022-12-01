<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\store\StoreSalesreturnRequest;
use App\Http\Requests\update\UpdateSalesreturnRequest;
use App\Models\Salesreturn;

class SalesreturnController extends Controller
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
     * @param  \App\Http\Requests\store\StoreSalesreturnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesreturnRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salesreturn  $salesreturn
     * @return \Illuminate\Http\Response
     */
    public function show(Salesreturn $salesreturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salesreturn  $salesreturn
     * @return \Illuminate\Http\Response
     */
    public function edit(Salesreturn $salesreturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\update\UpdateSalesreturnRequest  $request
     * @param  \App\Models\Salesreturn  $salesreturn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesreturnRequest $request, Salesreturn $salesreturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salesreturn  $salesreturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salesreturn $salesreturn)
    {
        //
    }
}
