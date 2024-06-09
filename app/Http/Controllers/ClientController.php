<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clients.clientList');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.clientAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $client = Client::with('User')->find($id);
        return view('clients.clientView', [ 'client' => $client ], compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($client)
    {
        return view('clients.clientUpdate', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
