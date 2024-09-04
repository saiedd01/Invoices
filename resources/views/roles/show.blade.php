@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />



@section('title')
    عرض الصلاحيات - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ عرض
                الصلاحيات</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->


<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">{{ $role->name }} - الصلاحيات</h4>
                    <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">رجوع</a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if (!empty($rolePermissions))
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الصلاحية</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rolePermissions as $index => $permission)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $permission->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center">لا توجد صلاحيات لهذا الدور.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
