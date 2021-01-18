<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        @if($avatar = Auth::user()->avatar)
            <div class="image d-flex align-items-center">
                <img src="{{$avatar}}" class="avatar img-circle elevation-2" alt="avatar">
            </div>
        @endif
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

            <li class="nav-item has-treeview {{ Nav::urlDoesContain('blog','menu-open') }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-newspaper"></i>
                    <p>
                        Blog
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('admin.blog.articles.index')}}"
                           class="nav-link {{ Nav::isResource('articles') }}">
                            <i class="nav-icon fa fa-file-alt"></i>
                            <p>Articles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.blog.categories.index')}}"
                           class="nav-link {{ Nav::isResource('blog/categories') }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.users.index')}}" class="nav-link {{ Nav::isResource('users') }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.companies.index')}}" class="nav-link {{ Nav::isResource('companies') }}">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Companies</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.volunteers.index')}}" class="nav-link {{ Nav::isResource('volunteers') }}">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>Volunteers</p>
                </a>
            </li>

            <li class="nav-item has-treeview {{ Nav::urlDoesContain('jobs','menu-open') }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <p>
                        Jobs
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('admin.sectors.index')}}"
                           class="nav-link {{ Nav::isResource('sectors') }}">
                            <i class="nav-icon fas fa-tractor"></i>
                            <p>Sectors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.roles.index')}}"
                           class="nav-link {{ Nav::isResource('roles') }}">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.search-queries.index')}}"
                   class="nav-link {{ Nav::isResource('search-queries') }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Search history</p>
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
