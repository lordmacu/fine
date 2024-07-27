<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:purchase_order list', ['only' => ['index', 'show']]);
        $this->middleware('can:purchase_order create', ['only' => ['create', 'store']]);
        $this->middleware('can:purchase_order edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:purchase_order delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('client', 'products')->get();
        return view('admin.purchase_order.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('admin.purchase_order.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_creation_date' => 'required|date',
            'required_delivery_date' => 'required|date',
            'order_consecutive' => 'required|string|unique:purchase_orders,order_consecutive',
            'observations' => 'nullable|string',
            'delivery_address' => 'required|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $purchaseOrder = PurchaseOrder::create($request->only(
            'client_id',
            'order_creation_date',
            'required_delivery_date',
            'order_consecutive',
            'observations',
            'delivery_address'
        ));

        foreach ($request->products as $product) {
            $purchaseOrder->products()->attach($product['product_id'], [
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);
        }

        return redirect()->route('admin.purchase_orders.index')->with('message', 'Purchase Order created successfully.');
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $clients = Client::all();
        $products = Product::all();
        return view('admin.purchase_order.edit', compact('purchaseOrder', 'clients', 'products'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_creation_date' => 'required|date',
            'required_delivery_date' => 'required|date',
            'order_consecutive' => 'required|string|unique:purchase_orders,order_consecutive,' . $purchaseOrder->id,
            'observations' => 'nullable|string',
            'delivery_address' => 'required|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $purchaseOrder->update($request->only(
            'client_id',
            'order_creation_date',
            'required_delivery_date',
            'order_consecutive',
            'observations',
            'delivery_address'
        ));

        $purchaseOrder->products()->detach();

        foreach ($request->products as $product) {
            $purchaseOrder->products()->attach($product['product_id'], [
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ]);
        }

        return redirect()->route('admin.purchase_orders.index')->with('message', 'Purchase Order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return redirect()->route('admin.purchase_orders.index')->with('message', 'Purchase Order deleted successfully.');
    }

    public function getClientProducts($clientId)
    {
        $products = Product::where('client_id', $clientId)->get();
        return response()->json($products);
    }
    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('admin.purchase_order.show', compact('purchaseOrder'));
    }

}
