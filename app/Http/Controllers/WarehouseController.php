<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        // $warehouses = Warehouse::with('products')->get();
        $warehouses = Warehouse::all();
        return view('warehouses.index', compact('warehouses'));
    }

    public function show($id)
    {
        $warehouse = Warehouse::with('productWarehouses.product')->findOrFail($id);
        // dd($warehouse->productWarehouses->first()->product);
        return view('warehouses.show', compact('warehouse'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'import_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        $warehouse = Warehouse::findOrFail($request->warehouse_id);

        $product->warehouses()->attach($warehouse->id, [
            'quantity' => $request->quantity,
            'purchase_price' => $request->purchase_price,
            'import_date' => $request->import_date,
        ]);

        return response()->json(['message' => 'Product added to warehouse successfully!']);
    }
}
