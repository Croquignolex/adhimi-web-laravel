@extends('layouts.backoffice.admin.group-show')

@section('group.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection