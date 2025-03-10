<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product; // Đổi theo model bạn dùng

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
}
