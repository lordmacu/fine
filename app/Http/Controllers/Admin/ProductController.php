<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:product list', ['only' => ['index']]);
        $this->middleware('can:product create', ['only' => ['create', 'store']]);
        $this->middleware('can:product edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:product delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = (new Product)->newQuery();

        if (request()->has('search')) {
            $products->where('product_name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $products->orderBy($attribute, $sort_order);
        } else {
            $products->latest();
        }

        $products = $products->paginate(config('admin.paginate.per_page'))
            ->onEachSide(config('admin.paginate.each_side'));

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('admin.product.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:products,code',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
        ]);

        Product::create([
            'code' => $request->code,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'client_id' => $request->client_id,
        ]);

        return redirect()->route('admin.product.index')
            ->with('message', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $clients = Client::all();
        return view('admin.product.edit', compact('product', 'clients'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.product.index')
            ->with('message', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('message', 'Product deleted successfully');
    }
}
