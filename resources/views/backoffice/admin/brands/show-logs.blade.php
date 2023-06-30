@extends('layouts.backoffice.admin.brand-show')

@section('brand.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection