<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product; // Đổi theo model bạn dùng
// DB Facade
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'Chưa chọn file.');
        }

        // Đọc file Excel
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        dd($rows);

        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // Bỏ qua hàng tiêu đề

            Product::create([
                'code'        => $row[0],
                'name'        => $row[1],
                'quantity'    => (int) $row[2],
                'price'       => (float) $row[3],
                'description' => $row[4],
            ]);
        }

        return back()->with('success', 'Import thành công!');
    }

    public function preview(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $headers = $worksheet->toArray()[0]; // Lấy tiêu đề cột

        return view('import_preview', compact('headers', 'file'));
    }

    public function showImportForm()
    {
        return view('products.import');
    }

    public function previewImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('excel_file');

        if (!$file) {
            return response()->json(['error' => 'No file uploaded.'], 422);
        }

        

        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        if (empty($data[0])) {
            return response()->json(['error' => 'File is empty or invalid format.'], 422);
        }

        // Lấy hàng đầu tiên làm tiêu đề cột
        $headers = array_shift($data);

        $allowedColumns = Schema::getColumnListing('products');

        // return view('import_preview', compact('headers', 'data'));
        return response()->json([
            'success' => true,
            'headers' => $headers, // Lấy dòng đầu tiên làm header
            'data' => $data,
            'allowedColumns' => $allowedColumns
        ]);
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv',
            'selected_columns' => 'required'
        ]);

        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Lấy danh sách cột được chọn từ frontend
        $selectedColumns = json_decode($request->input('selected_columns'),true);

        DB::beginTransaction();
        try {
            foreach ($rows as $key => $row) {
                if ($key == 0) continue; // Bỏ qua hàng tiêu đề

                $codeIndex = $selectedColumns['code'] ?? null;
                if ($codeIndex === null || !isset($row[$codeIndex])) continue;

                $code = $row[$codeIndex];
                $product = Product::where('code', $code)->first();

                if ($product) {
                    // Cập nhật sản phẩm nếu tồn tại
                    if (isset($selectedColumns['quantity']))
                        $product->quantity += (int) $row[$selectedColumns['quantity']] ?? 0;

                    foreach ($selectedColumns as $column => $index) {
                        if ($column !== 'code' && $column !== 'quantity') {
                            $product->$column = $row[$index] ?? $product->$column;
                        }
                    }
                    $product->save();
                } else {
                    // Tạo sản phẩm mới
                    $newProduct = new Product();
                    foreach ($selectedColumns as $column=>$index) {
                        $newProduct->$column = $row[$index] ?? null;
                    }
                    $newProduct->save();
                }
            }

            DB::commit();
            return response()->json(['message' => 'Import thành công!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Lỗi khi nhập dữ liệu!', 'error' => $e->getMessage()], 500);
        }
    }

}
