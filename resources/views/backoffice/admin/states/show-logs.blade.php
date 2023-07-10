@extends('layouts.backoffice.admin.state-show')

@section('state.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection