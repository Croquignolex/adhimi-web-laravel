@props(['title' => '', 'breadcrumb_items' => []])

<ul class="nav navbar-nav d-flex align-items-center">
    <li class="nav-item">
        <strong class="d-block d-sm-block d-md-none">{{ format_text($title, 20) }}</strong>
        <strong class="d-none d-md-block d-lg-none d-xl-none">{{ format_text($title, 40) }}</strong>
        <strong class="d-none d-lg-block">{{ format_text($title, 50) }}</strong>
    </li>

    @if(count($breadcrumb_items) > 0)
        <li class="nav-item d-none d-lg-block">
            <i data-feather='more-vertical' class="mx-50"></i>
        </li>
    @endif

    @foreach($breadcrumb_items as $item)
        <li class="nav-item d-none d-lg-block">
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
        <li class="nav-item d-none d-lg-block">
            <i data-feather='chevron-right' class="mx-50"></i>
        </li>
    @endforeach

    @if(count($breadcrumb_items) > 0)
        <li class="nav-item d-none d-lg-block">
            <span>{{ format_text($title, 50) }}</span>
        </li>
    @endif
</ul>