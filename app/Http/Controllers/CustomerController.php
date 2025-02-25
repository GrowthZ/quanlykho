<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        if ($request->has('search')) {
            $query->where('company_name', 'like', "%{$request->search}%")
                  ->orWhere('tax_code', 'like', "%{$request->search}%");
        }
        $customers = $query->orderBy('company_name')->paginate(10);
        return view('customers.index', compact('customers'));
    }
    
    public function create()
    {
        return view('customers.create');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'tax_code' => 'nullable|string|max:50',
            'representative' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);
        Customer::create($validatedData);
        return redirect()->route('customers.index')->with('success', 'Khách hàng đã được thêm.');
    }

    public function update(Request $request, $id)
    {
        // Tìm khách hàng theo ID
        $customer = Customer::findOrFail($id);
        // Validate dữ liệu
        $validatedData = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'tax_code' => 'nullable|string|max:50',
            'representative' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        // Cập nhật thông tin khách hàng
        $customer->update($validatedData);

        // Redirect hoặc trả về JSON
        return redirect()->route('customers.index')->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function destroy($id)
    {
        // Tìm khách hàng theo ID
        $customer = Customer::findOrFail($id);

        // Xóa khách hàng
        $customer->delete();

        // Trả về JSON hoặc redirect
        return redirect()->route('customers.index')->with('success', 'Xoá khách hàng thành công!');
    }
}
