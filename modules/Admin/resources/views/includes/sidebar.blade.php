<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image d-flex align-items-center">
            <img src="{{Auth::getUser()->avatar}}" class="avatar img-circle elevation-2" alt="avatar">
        </div>
        <div class="info d-flex align-items-center">
            <p class="d-block text-white m-0">{{$name}}</p>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy">
            <li class="nav-item">
                <a href="{{route('admin.dashboard')}}" class="nav-link {{ Nav::isRoute('admin.dashboard') }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.pages.index')}}" class="nav-link {{ Nav::isResource('pages') }}">
                    <i class="nav-icon fa fa-file-signature"></i>
                    <p>Pages</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.articles.index')}}" class="nav-link {{ Nav::isResource('articles') }}">
                    <i class="nav-icon fa fa-newspaper"></i>
                    <p>Blog</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.users.index')}}" class="nav-link {{ Nav::isResource('users') }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            @if(config('telescope.enabled'))
                <li class="nav-item">
                    <a href="{{config('app.url').route('telescope',null,false)}}" class="nav-link"
                       target=_blank>
                        <i class="nav-icon fa">
                            <svg-vue icon="telescope"></svg-vue>
                        </i>
                        <p>Telescope</p>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
