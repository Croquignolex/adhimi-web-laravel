@extends('layouts.backoffice.admin.shop-show')

@section('shop.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection