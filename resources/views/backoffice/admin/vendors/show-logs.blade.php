@extends('layouts.backoffice.admin.vendor-show')

@section('vendor.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection