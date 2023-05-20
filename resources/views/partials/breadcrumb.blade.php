<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h4 class="content-header-title float-left mb-0">{{ $title }}</h4>
                @if(isset($items))
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            @foreach($items as $item)
                                @if($loop->last)
                                    <li class="breadcrumb-item active">
                                        {{ $item }}
                                    </li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>