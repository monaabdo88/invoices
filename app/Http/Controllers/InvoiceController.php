<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Invoice_attachments;
use App\Models\Invoices_Details;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateInvoiceRequest $request)
    {
        //add invoice code
        Invoice::create([
            'invoice_number'    => $request->invoice_number,
            'invoice_Date'      => $request->invoice_Date,
            'Due_date'          => $request->Due_date,
            'product'           => $request->product,
            'section_id'        => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount'          => $request->Discount,
            'Value_VAT'         => $request->Value_VAT,
            'Rate_VAT'          => $request->Rate_VAT,
            'Total'             => $request->Total,
            'Status'            => 'غير مدفوعة',
            'Value_Status'      => 2,
            'note'              => $request->note,
        ]);
        //add invoice details code
        $invoice_id = Invoice::latest()->first()->id;
        Invoices_Details::create([
            'invoice_id'        => $invoice_id,
            'invoice_number'    => $request->invoice_number,
            'product'           => $request->product,
            'Section'           => $request->Section,
            'Status'            => 'غير مدفوعة',
            'Value_Status'      => 2,
            'note'              => $request->note,
            'Payment_Date'      => $request->Due_date,
            'user'              => Auth::user()->name
        ]);
        //add invoice attachments code
        if($request->hasFile('pic'))
        {
            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            $attachments = new Invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);

        }
        session()->flash('success', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show',compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    /**
     * get the section products
     * @param int $id
     * @return array $products
     */
    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('name','id');
        return json_encode($products);
    }
    /**
     * view attachment file
     * @param $invoice_number , $file_name
     * @return response
     */
    public function view_file($invoice_number, $file_name)
    {
        $filePath = $invoice_number . '/' . $file_name;
        $attachment = Storage::disk('public_uploads')->path($filePath);
        return response()->file($attachment);
    }
    /**
     * download attachment file
     * @param $invoice_number , $file_name
     * @return response
     */
    public function download_file($invoice_number, $file_name)
    {
        $filePath = $invoice_number . '/' . $file_name;
        $attachment = Storage::disk('public_uploads')->path($filePath);
        return response()->download($attachment);
    }
    /**
     * Delete Invoice Attachment
     * @param array
     */
    public function delete_file(Request $request)
    {
        $attachment_id = $request->id_file;
        $attachment = Invoice_attachments::findOrFail($attachment_id);
        $attachment->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('success', 'تم حذف المرفق بنجاح');
        return back();
    }
    /**
     * upload new attahment
     */
    public function uploadFile(Request $request)
    {
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',
    
            ], [
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]);
            
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            $attachments = new Invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $invoice_number), $imageName);

        
        session()->flash('success', 'تم اضافة المرفق بنجاح');
        return back();
    }
}
