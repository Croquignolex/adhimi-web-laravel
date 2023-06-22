@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    @include('partials.backoffice.admin.logs', ['logs' => $logs, 'entity' => false])
@endsection