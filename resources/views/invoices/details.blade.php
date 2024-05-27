@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل الفاتورة
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{url("invoices")}}">الفواتير</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    التفاصيل</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('success')
    @include('error')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <h5> تفاصيل الفاتورة </h5>
                    </div>
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">ملعومات الفاتورة
                                                </a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab"> المرفقات </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">
                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">رقم الفاتورة</th>
                                                            <td>{{ $invoices->invoice_number }}</td>
                                                            <th scope="row">تاريخ الاصدار</th>
                                                            <td>{{ $invoices->invoice_Date }}</td>
                                                            <th scope="row">تاريخ الاستحقاق</th>
                                                            <td>{{ $invoices->Due_date }}</td>
                                                            <th scope="row">القسم</th>
                                                            <td>{{ $invoices->Section->section_name }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">المنتج</th>
                                                            <td>{{ $invoices->product }}</td>
                                                            <th scope="row">مبلغ التحصيل</th>
                                                            <td>{{ $invoices->Amount_collection }}</td>
                                                            <th scope="row">مبلغ العمولة</th>
                                                            <td>{{ $invoices->Amount_Commission }}</td>
                                                            <th scope="row">الخصم</th>
                                                            <td>{{ $invoices->Discount }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">نسبة الضريبة</th>
                                                            <td>{{ $invoices->Rate_VAT }}</td>
                                                            <th scope="row">قيمة الضريبة</th>
                                                            <td>{{ $invoices->Value_VAT }}</td>
                                                            <th scope="row">الاجمالي مع الضريبة</th>
                                                            <td>{{ $invoices->Total }}</td>
                                                            <th scope="row">الحالة الحالية</th>

                                                            @if ($invoices->Value_Status == 1)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $invoices->Status }}</span>
                                                                </td>
                                                            @elseif($invoices->Value_Status == 2)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>
                                                                </td>
                                                            @endif
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">ملاحظات</th>
                                                            <td>{{ $invoices->note }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table table" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">#</th> {{-- id --}}
                                                            <th class="border-bottom-0">رقم الفاتورة</th> {{-- invoice_number --}}
                                                            <th class="border-bottom-0">نوع المنتج</th> {{-- product --}}
                                                            <th class="border-bottom-0">القسم</th> {{-- section --}}
                                                            <th class="border-bottom-0">الحالة الدفع</th> {{-- status --}}
                                                            <th class="border-bottom-0">تاريخ الدفع</th> {{-- Payment_date --}}
                                                            <th class="border-bottom-0">ملاحظات</th> {{-- note --}}
                                                            <th class="border-bottom-0">تاريخ الإضافة</th> {{-- created_at --}}
                                                            <th class="border-bottom-0">المستخدم</th> {{-- user --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($details as $details)
                                                            <?php $i++; ?>
                                                            <tr>
                                                                <th>{{ $i }}</th>
                                                                <th>{{ $details->invoice_number }}</th>
                                                                <th>{{ $details->product }}</th>
                                                                <th>{{ $invoices->section->section_name }}</th>
                                                                @if ($details->Value_Status == 1)
                                                                    <td><span
                                                                            class="badge badge-pill badge-success">{{ $details->Status }}</span>
                                                                    </td>
                                                                @elseif($details->Value_Status == 2)
                                                                    <td><span
                                                                            class="badge badge-pill badge-danger">{{ $details->Status }}</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge badge-pill badge-warning">{{ $details->Status }}</span>
                                                                    </td>
                                                                @endif
                                                                <th>{{ $details->Payment_Date }}</th>
                                                                <th>{{ $details->note }}</th>
                                                                <th>{{ $details->created_at }}</th>
                                                                <th>{{ $details->user }}</th>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile"
                                                                name="file_name" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoices->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoices->id }}">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">تاكيد</button>
                                                    </form>
                                                </div>
                                                <br>
                                                <div class="table-responsive mt-15">
                                                    <table class="table table" style="text-align:center">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">#</th> {{-- id --}}
                                                                <th class="border-bottom-0"> اسم الملف</th> {{-- invoice_number --}}
                                                                <th class="border-bottom-0">المستخدم</th> {{-- user --}}
                                                                <th class="border-bottom-0">تاريخ الإضافة</th> {{-- created_at --}}
                                                                <th class="border-bottom-0">العمليات </th> {{-- actions --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($attachment as $attachment)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->Created_by }}</td>
                                                                    <td>{{ $attachment->created_at }}</td>
                                                                    <td colspan="2">
                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-eye"></i>&nbsp;
                                                                            عرض
                                                                        </a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل
                                                                        </a>

                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-id="{{ $attachment->id }}"
                                                                            data-file_name="{{ $attachment->file_name }}"
                                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                                            data-target="#delete_file">حذف
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('delete_file') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    {{-- delete --}}
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
