@extends('layouts.main')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    تعديل فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تعديل فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('invoices.update', $invoice->id) }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    {{-- 1 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">رقم الفاتورة</label>
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                            <input type="text" class="form-control" id="inputName" name="invoice_number"
                                title="يرجي ادخال رقم الفاتورة" value="{{ $invoice->invoice_number }}" required>
                        </div>

                        <div class="col">
                            <label>تاريخ الفاتورة</label>
                            <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                type="text" value="{{ $invoice->invoice_Date }}" required>
                        </div>

                        <div class="col">
                            <label>تاريخ الاستحقاق</label>
                            <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                type="text" value="{{ $invoice->Due_date }}" required>
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">القسم</label>
                            <select name="Section" class="form-control SlectBox">
                                <!--placeholder-->
                                
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" {{ ($invoice->section_id == $section->id)? 'selected':'' }}> {{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">المنتج</label>
                            <select id="product" name="product" class="form-control">
                                <option value="{{ $invoice->product }}"> {{ $invoice->product }}</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ التحصيل</label>
                            <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="{{ $invoice->Amount_collection }}">
                        </div>
                    </div>


                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ العمولة</label>
                            <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="{{ $invoice->Amount_Commission }}" required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الخصم</label>
                            <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                title="يرجي ادخال مبلغ الخصم "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="{{ $invoice->Discount }}" required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                            <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                <!--placeholder-->
                               
                                <option value="5%" {{ ($invoice->Rate_VAT == '5%')? 'selected' : ''  }}>5%</option>
                                <option value="10%" {{ ($invoice->Rate_VAT =='10%')? 'selected' : ''  }}>10%</option>
                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                            <input type="text" class="form-control" id="Value_VAT" name="Value_VAT"
                                value="{{ $invoice->Value_VAT }}" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                            <input type="text" class="form-control" id="Total" name="Total" readonly
                                value="{{ $invoice->Total }}">
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">ملاحظات</label>
                            <textarea class="form-control" id="exampleTextarea" name="note" rows="3">{{ $invoice->note }}</textarea>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">حالة الدفع</label>
                            <select class="form-control" id="Status" name="Status" required>
                                <option {{ ($invoice->Value_Status == '2')? 'selected': '' }} value="2">غير مدفوعة</option>
                                <option {{ ($invoice->Value_Status == '1')? 'selected': '' }} value="1">مدفوعة</option>
                                <option {{ ($invoice->Value_Status == '3')? 'selected': '' }} value="3">مدفوعة جزئيا</option>
                            </select>
                        </div>

                        <div class="col">
                            <label>تاريخ الدفع</label>
                            <input class="form-control fc-datepicker" name="Payment_Date" value="{{ $invoice->Payment_Date }}" placeholder="YYYY-MM-DD"
                                type="text">
                        </div>


                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tax.js') }}"></script>
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

        $(document).ready(function() {
            $('select[name="Section"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });


        
    </script>


@endsection