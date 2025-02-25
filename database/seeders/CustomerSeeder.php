<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'company_name' => 'Công ty TNHH ABC',
                'address' => 'Số 12, Quận 1, TP. Hồ Chí Minh',
                'phone' => '0901234567',
                'tax_code' => '1234567890',
                'representative' => 'Nguyễn Văn A',
                'position' => 'Giám đốc'
            ],
            [
                'company_name' => 'Công ty CP XYZ',
                'address' => 'Số 34, Quận 3, TP. Hồ Chí Minh',
                'phone' => '0912345678',
                'tax_code' => '0987654321',
                'representative' => 'Trần Thị B',
                'position' => 'Kế toán trưởng'
            ],
            [
                'company_name' => 'Công ty TNHH 3C',
                'address' => 'Số 56, Quận 2, TP. Hà Nội',
                'phone' => '0934567890',
                'tax_code' => '5678901234',
                'representative' => 'Phạm Văn C',
                'position' => 'Trưởng phòng kinh doanh'
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
