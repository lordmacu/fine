<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:client list', ['only' => ['index']]);
        $this->middleware('can:client create', ['only' => ['create', 'store']]);
        $this->middleware('can:client edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:client delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $clients = (new Client)->newQuery();

        if (request()->has('search')) {
            $clients->where('client_name', 'Like', '%'.request()->input('search').'%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $clients->orderBy($attribute, $sort_order);
        } else {
            $clients->latest();
        }

        $clients = $clients->paginate(config('admin.paginate.per_page'))
            ->onEachSide(config('admin.paginate.each_side'));

        return view('admin.client.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'nit' => 'required|string|unique:clients,nit',
            'client_type' => 'required|in:pareto,balance',
            'payment_type' => 'required|in:cash,credit',
            'email' => 'required|email|unique:clients,email',

        ]);

        Client::create([
            'client_name' => $request->client_name,
            'nit' => $request->nit,
            'client_type' => $request->client_type,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.client.index')
            ->with('message', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'nit' => 'required|string|unique:clients,nit,' . $client->id,
            'client_type' => 'required|in:pareto,balance',
            'payment_type' => 'required|in:cash,credit',
            'email' => 'required|string|email|max:255|unique:clients,email,' . $client->id,
        ]);

        $client->update($request->all());

        return redirect()->route('admin.client.index')
            ->with('message', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.client.index')
            ->with('message', 'Client deleted successfully');
    }


    public function import(Request $request)
    {
        $request->validate([
            'clients_excel' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ClientsImport, $request->file('clients_excel'));

        return redirect()->route('admin.client.index')->with('message', 'Clients imported successfully.');
    }
}
