<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller {
    // Hiển thị danh sách sản phẩm
    public function index() {
        $products = Product::orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    // Hiển thị form thêm sản phẩm
    public function create() {
        $categories = Category::all();
        return view('products.create', compact('categories'));

    }

    // Lưu sản phẩm mới
    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:products',
            'quantity' => 'nullable|integer|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'origin' => 'nullable|string'
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm!');
    }

    // Hiển thị chi tiết sản phẩm
    public function show(Product $product) {
        return view('products.show', compact('product'));
    }

    // Hiển thị form sửa sản phẩm
    public function edit(Product $product) {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product) {
        $request->validate([
            'quantity' => 'nullable|integer|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'origin' => 'nullable|string'
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    // Xóa sản phẩm
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa!');
    }

    public function showCartPage()
    {
        $products = Product::orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        return view('products.search', compact('products'));
    }

    public function search(Request $request)
    {
        $codes = $request->input('codes');
        $codeList = preg_split('/[\s,]+/', trim($codes[0]));
        $products = Product::whereIn('code', $codeList)->get();

        return response()->json($products);
    }
}
