@extends('layouts.backoffice.admin.coupon-show')

@section('coupon.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection