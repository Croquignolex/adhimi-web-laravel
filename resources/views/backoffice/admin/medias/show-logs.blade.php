@extends('layouts.backoffice.admin.customer-show')

@section('customer.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection