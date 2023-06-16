@extends('layouts.backoffice.admin.country-show')

@section('country.content')
    @include('partials.backoffice.admin.logs', ['logs' => $logs, 'creator' => true, 'entity' => false]))
@endsection