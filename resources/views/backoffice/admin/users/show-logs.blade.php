@extends('layouts.backoffice.admin.user-show')

@section('user.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection