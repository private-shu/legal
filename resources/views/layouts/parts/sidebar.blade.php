<sidebar>
    <div class="collapse show list-group" id="asideNavbarSupportedContent">
        <ul class="navbar-nav mt-3 ml-2">
            <li class="nav-item" data-toogle="collapse">
                <a href="#collapse-reserve-a" class="nav-link text-nowrap" style="font-size:16px;" data-toggle="collapse" aria-expanded="true"><i class="fas fa-file-edit fa-lg pr-1"></i>案件管理</a>
            </li>
            <ul id="collapse-reserve-a" class="collapse show">
                <li style="list-style-type: disc;"><a class="nav-link  @if(Request::routeIs('contract.list')) active @endif" href="{{ route('contract.list') }}">案件一覧</a></li>
                <li style="list-style-type: disc;"><a class="nav-link @if(Request::routeIs('contract.create')) active @endif" href="{{ route('contract.create') }}">新規登録</a></li>
                <li style="list-style-type: disc;"><a class="nav-link @if(Request::routeIs('contract.summary')) active @endif" href="{{ route('contract.summary') }}">集計</a></li>
            </ul>
            @if (Auth::user()->role_id == 1)
                <hr>
                <li class="nav-item" data-toogle="collapse">
                    <a href="#collapse-reserve-b" class="nav-link text-nowrap" style="font-size:16px;" data-toggle="collapse" aria-expanded="true"><i class="fas fa-users-cog fa-lg pr-1"></i>アカウント管理</a>
                </li>
                <ul id="collapse-reserve-b" class="collapse show">
                    <li style="list-style-type: disc;"><a class="nav-link @if(Request::routeIs('user.list')) active @endif" href="{{ route('user.list') }}">アカウント一覧</a></li>
                    <li style="list-style-type: disc;"><a class="nav-link @if(Request::routeIs('user.create')) active @endif" href="{{ route('user.create') }}">アカウント作成</a></li>
                </ul>
            @endif
            <hr>
            <li><a class="nav-link text-nowrap" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa-solid fa-lg fa-right-from-bracket"></i>サインアウト</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </div>
</sidebar>