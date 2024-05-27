@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('title')
    الفواتير الغير المدفوعة
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{url("invoices")}}">الفواتير</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير الغير المدفوعة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('success')
    <!-- row -->
    <div class="row">
        <!--/div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-contenct-between">
                        <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp; اضافة فاتورة
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th> {{-- id --}}
                                    <th class="border-bottom-0">رقم الفاتورة</th> {{-- invoice_number --}}
                                    <th class="border-bottom-0">تاريخ الفاتورة</th> {{-- Invoice_date --}}
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th> {{-- due_data --}}
                                    <th class="border-bottom-0">القسم</th> {{-- section --}}
                                    <th class="border-bottom-0">المنتج</th> {{-- product --}}
                                    <th class="border-bottom-0">نسبة الضريبة</th> {{-- rate_vat --}}
                                    <th class="border-bottom-0">قيمة الضريبة</th> {{-- value_vat --}}
                                    <th class="border-bottom-0">الخصم</th> {{-- discount --}}
                                    <th class="border-bottom-0">الاجمالي</th> {{-- total --}}
                                    <th class="border-bottom-0">الحالة</th> {{-- status --}}
                                    <th class="border-bottom-0">ملاحظات</th> {{-- note --}}
                                    <th class="border-bottom-0">العمليات</th> {{-- actions --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($invoices as $invoice)
                                    <?php $i++; ?>
                                    <tr>
                                        <td> {{ $i }} </td>
                                        <td> {{ $invoice->invoice_number }} </td>
                                        <td> {{ $invoice->invoice_Date }} </td>
                                        <td> {{ $invoice->Due_date }} </td>
                                        <td> <a href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">
                                                {{ $invoice->section->section_name }} </td>
                                        <td> {{ $invoice->product }} </td>
                                        <td> {{ $invoice->Rate_VAT }} </td>
                                        <td> {{ $invoice->Value_VAT }} </td>
                                        <td> {{ $invoice->Discount }} </td>
                                        <td> {{ $invoice->Total }} </td>
                                        <td>
                                            @if ($invoice->Value_Status == 1)
                                                <span class="text-success"> {{ $invoice->Status }} </span>
                                            @elseif ($invoice->Value_Status == 2)
                                                <span class="text-danger"> {{ $invoice->Status }} </span>
                                            @else
                                                <span class="text-warning"> {{ $invoice->Status }} </span>
                                            @endif
                                        </td>
                                        <td> {{ $invoice->note }} </td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    {{-- edit invoices --}}
                                                    <a class="dropdown-item"
                                                        href=" {{ url('edit_invoice') }}/{{ $invoice->id }}">تعديل
                                                        الفاتورة</a>

                                                    {{-- delete invoices --}}
                                                    <a class="dropdown-item" href="#" data-id="{{ $invoice->id }}"
                                                        data-toggle="modal" data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                        الفاتورة</a>

                                                    {{-- change_Status --}}
                                                    <a class="dropdown-item"
                                                        href="{{ url('Status_show') }}/{{ $invoice->id }}"><i
                                                            class=" text-success  fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                        حالة
                                                        الدفع</a>

                                                </div>
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
    <!-- row closed -->
    {{-- delete --}}
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('delete') }}" method="post">

                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية الحذف ؟</h6>
                        </p>

                        <input type="hidden" name="id" id="id" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
@endsection
