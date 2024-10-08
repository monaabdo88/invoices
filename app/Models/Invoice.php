<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date',
    ];
    protected $deleted_at;
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function Invoice_Details()
    {
        return $this->hasMany(Invoices_Details::class);
    }
    public function Invoice_attachments()
    {
        return $this->hasMany(Invoice_attachments::class);
    }
}
