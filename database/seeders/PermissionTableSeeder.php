<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'الفواتير',
            'الفواتير المدفوعة',
            'الفواتير المدفوعة جزئيا',
            'الفواتير الغير مدفوعة',
            'ارشيف الفواتير',
            'التقارير',
            'تقرير الفواتير',
            'تقرير العملاء',
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',
            'المنتجات',
            'الاقسام',
    
    
            'اضافة فاتورة',
            'حذف الفاتورة',
            'تصدير EXCEL',
            'تعديل الفاتورة',
            'ارشفة الفاتورة',
            'طباعة الفاتورة',
            'اضافة مرفق',
            'حذف المرفق',
    
            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',
    
            'عرض صلاحية',
            'اضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',
    
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
    
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'الاشعارات',
        ];
        foreach($permissions as $permission)
        {
            Permission::create(['name'  => $permission]);
        }
    }
}
