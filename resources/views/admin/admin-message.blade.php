<ul class="nav navbar-nav" style="margin-right: 10px">
    <li class="dropdown dropdown-notification nav-item">
        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="true">
            <i class="ficon feather icon-bell"></i>
            @if ($total > 0)
                <span class="badge badge-pill badge-primary badge-up">{{ $total }}</span>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right ">
            <li class="dropdown-menu-header">
                <div class="dropdown-header m-0 p-2">
                    <h3 class="white">您有{{ $total }}条</h3><span class="grey darken-2">未阅读消息通知</span>
                </div>
            </li>
            @foreach ($messages as $message)
            <li class="scrollable-container media-list ps ps--active-y">
                <a class="d-flex justify-content-between" href="{{ route('admin-message', ['id' => $message->id]) }}">
                    <div class="media d-flex align-items-start">
                        <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
                        <div class="media-body">
                            <h6 class="primary media-heading">{{ $type_name[$message->type] }}</h6>
                            <small class="notification-text">
                                {{ \Illuminate\Support\Str::limit($message->title, 40) }}
                            </small>
                        </div>
                        <small>
                            <time class="media-meta">
                                {{ format_datetime($message, 'created_at') }}
                            </time>
                        </small>
                    </div>
                </a>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; right: 0px; height: 254px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 184px;"></div>
                </div>
            </li>
            @endforeach
            <li class="dropdown-menu-footer">
                <a class="dropdown-item p-1 text-center" href="{{ route('admin-message', ['status' => 0]) }}">阅读全部通知</a>
            </li>
        </ul>
    </li>
</ul>
