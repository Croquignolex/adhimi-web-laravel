<ul class="nav navbar-nav d-flex align-items-center">
    <li class="nav-item">
        <strong>{{ $title }}</strong>
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
            <span>{{ $title }}</span>
        </li>
    @endif
</ul>