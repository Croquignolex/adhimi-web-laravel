@extends('layouts.backoffice.admin.attribute-value-show')

@section('attribute_value.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection