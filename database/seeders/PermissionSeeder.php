<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'role' => [
                [
                    'name' => 'role-list',
                    'label' => 'مدیریت نقش',
                ],
//                [
//                    'name' => 'role-create',
//                    'label' => 'ایجاد نقش',
//                ],
//                [
//                    'name' => 'role-edit',
//                    'label' => 'ویرایش نقش',
//                ],
//                [
//                    'name' => 'role-delete',
//                    'label' => 'حذف نقش',
//                ],
            ],
            'staff' => [
                [
                    'name' => 'staff-list',
                    'label' => 'مدیریت کارکنان',
                ],
//                [
//                    'name' => 'staff-create',
//                    'label' => 'ایجاد کارکنان',
//                ],
//                [
//                    'name' => 'staff-edit',
//                    'label' => 'ویرایش کارکنان',
//                ],
//                [
//                    'name' => 'staff-delete',
//                    'label' => 'حذف کارکنان',
//                ],
            ],
            'workshop' => [
                [
                    'name' => 'workshop-list',
                    'label' => 'مدیریت کارگاه ها',
                ],
//                [
//                    'name' => 'workshop-create',
//                    'label' => 'ایجاد کارگاه ها',
//                ],
//                [
//                    'name' => 'workshop-edit',
//                    'label' => 'ویرایش کارگاه ها',
//                ],
//                [
//                    'name' => 'workshop-delete',
//                    'label' => 'حذف کارگاه ها',
//                ],
                [
                    'name' => 'workshop-rollcall',
                    'label' => ' تردد کارگاه',
                ],
            ],
            'plane' => [
                [
                    'name' => 'plane-list',
                    'label' => 'مدیریت پلن ها',
                ],
//                [
//                    'name' => 'plane-create',
//                    'label' => 'ایجاد پلن ها',
//                ],
//                [
//                    'name' => 'plane-edit',
//                    'label' => 'ویرایش پلن ها',
//                ],
//                [
//                    'name' => 'plane-delete',
//                    'label' => 'حذف پلن ها',
//                ],
                [
                    'name' => 'plane-rollcall',
                    'label' => ' تردد مهد',
                ],
            ],
            'product' => [
                [
                    'name' => 'product-list',
                    'label' => 'مدیریت بوقه',
                ],
//                [
//                    'name' => 'product-create',
//                    'label' => 'ایجاد بوقه',
//                ],
//                [
//                    'name' => 'product-edit',
//                    'label' => 'ویرایش بوقه',
//                ],
//                [
//                    'name' => 'product-delete',
//                    'label' => 'حذف بوقه',
//                ],
            ],
            'service' => [
                [
                    'name' => 'service-list',
                    'label' => 'مدیریت خدمات',
                ],
//                [
//                    'name' => 'service-create',
//                    'label' => 'ایجاد خدمات',
//                ],
//                [
//                    'name' => 'service-edit',
//                    'label' => 'ویرایش خدمات',
//                ],
//                [
//                    'name' => 'service-delete',
//                    'label' => 'حذف خدمات',
//                ],
            ],
            'user' => [
                [
                    'name' => 'user-list',
                    'label' => 'مدیریت افراد',
                ],
//                [
//                    'name' => 'user-create',
//                    'label' => 'ایجاد افراد',
//                ],
//                [
//                    'name' => 'user-edit',
//                    'label' => 'ویرایش افراد',
//                ],
//                [
//                    'name' => 'user-delete',
//                    'label' => 'حذف افراد',
//                ],
//                [
//                    'name' => 'user-cards',
//                    'label' => 'کارت افراد',
//                ],
            ],
            'factor' => [
                [
                    'name' => 'factor-create',
                    'label' => 'ایجاد فاکتور',
                ],
            ],
            'reserve' => [
                [
                    'name' => 'reserve',
                    'label' => 'رزروها',
                ],
            ],
            'rollcall' => [
                [
                    'name' => 'rollcall',
                    'label' => 'تردد',
                ],
            ],
            'reports' => [
                [
                    'name' => 'all-reports',
                    'label' => ' گزارشات',
                ],
//                [
//                    'name' => 'reports-factor',
//                    'label' => ' فاکتور',
//                ],
//                [
//                    'name' => 'reports-rollcall',
//                    'label' => ' تردد',
//                ],
//                [
//                    'name' => 'reports-plane',
//                    'label' => ' فاکتور',
//                ],
//                [
//                    'name' => 'reports-product',
//                    'label' => ' بوفه',
//                ],
//                [
//                    'name' => 'reports-service',
//                    'label' => ' خدمات',
//                ],
            ],

            'my_workshop' => [
                [
                    'name' => 'my-workshop',
                    'label' => 'کارگاه های من',
                ],
            ],
            'report_create' => [
                [
                    'name' => 'report-create',
                    'label' => 'ثبت گزارشات',
                ],
            ],
        ];

        foreach ($lists as $key => $items) {
            foreach ($items as $item) {
                $permission = Permission::where('name', $item['name'])->first();
                if (!$permission) {
                    Permission::create([
                        'name' => $item['name'],
                        'label' => $item['label'],
                    ]);
                }
                else
                {

                }
            }
        }
    }
}
