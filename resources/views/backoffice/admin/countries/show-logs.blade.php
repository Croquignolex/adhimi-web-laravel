@extends('layouts.backoffice.admin.country-show')

@section('country.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection