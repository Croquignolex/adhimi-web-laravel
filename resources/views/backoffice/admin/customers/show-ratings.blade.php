@extends('layouts.backoffice.admin.customer-show')

@section('customer.content')
    <div class="card-body">
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.ratings-table', ['ratings' => $ratings, 'customer' => false])
@endsection