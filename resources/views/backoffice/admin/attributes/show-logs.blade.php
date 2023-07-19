@extends('layouts.backoffice.admin.attribute-show')

@section('attribute.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection