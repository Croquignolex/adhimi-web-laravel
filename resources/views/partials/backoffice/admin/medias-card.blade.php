@props(['creator' => true])

@forelse($medias as $media)
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <img class="card-img-top" src="{{ $media->url }}" alt="..." />
            <div class="card-body">
                @if($media->is_local)
                    <span class="badge badge-pill badge-light-success mb-1">@lang('field.local')</span>
                @else
                    <span class="badge badge-light-danger mb-1">@lang('field.online')</span>
                @endif
                <div class="text-secondary">@lang('field.creation')</div>
                <div class="mt-25 mb-1"> @include('partials.backoffice.date-badge', ['model' => $media])</div>
                <div class="text-secondary">@lang('field.url')</div>
                <div class="mt-25 mb-1">
                    {{ $media->url }}
                    <a href="{{ $media->url }}" target="_blank">
                        <i data-feather="external-link" class="ml-25 mb-25 text-secondary"></i>
                    </a>
                </div>
                <div class="text-secondary">@lang('field.entity')</div>
                <div class="mt-25 mb-1">@include('partials.backoffice.admin.entity-data', ['model' => $media->mediatable])</div>
                @if($creator)
                    <div class="text-secondary">@lang('field.creator')</div>
                    <div class="mt-25 mb-1">@include('partials.backoffice.admin.entity-data', ['model' => $media->creator])</div>
                @endif
                <div class="text-secondary">@lang('field.description')</div>
                <div class="mt-25 mb-1"> {{ $media->description }}</div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-primary fade show" role="alert">
            <div class="alert-body text-center">
                @lang('general.no_records')
            </div>
        </div>
    </div>
@endforelse

<div class="col-12">
    {{ $medias->links('partials.backoffice.pagination') }}
</div>