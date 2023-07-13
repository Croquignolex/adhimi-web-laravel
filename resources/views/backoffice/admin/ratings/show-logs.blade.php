@extends('layouts.backoffice.admin.rating-show')

@section('rating.content')
    @include('partials.backoffice.admin.logs-table', ['logs' => $logs, 'entity' => false])
@endsection