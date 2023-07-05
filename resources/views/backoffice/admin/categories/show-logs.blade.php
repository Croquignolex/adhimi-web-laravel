@extends('layouts.backoffice.admin.category-show')

@section('category.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection