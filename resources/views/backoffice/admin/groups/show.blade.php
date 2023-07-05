@extends('layouts.backoffice.admin.group-show')

@section('group.content')
    <div class="card-body">
        <a href="{{ route('admin.groups.add.category', [$group]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.groups.add_category')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.categories-table', ['categories' => $categories, 'group' => false])
@endsection