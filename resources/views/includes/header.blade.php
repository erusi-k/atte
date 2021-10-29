<div class="header">
    <h1 class="header-title"><a href="{{url('/home')}}">Atte</a></h1>
    <ul class="header-list">
        <li><a class="header-list_content" href="{{url('/home')}}">ホーム</a></li>
        <li><a class="header-list_content" href="{{url('/datalist')}}">日付一覧</a></li>
        <li><a class="header-list_content" href="{{url('/individual')}}">個人実績一覧</a></li>
        <li><a class="header-list_content" href="{{url('/userlist')}}">登録者一覧</a></li>
        <li class="header-list_content">
            <form method="POST" action="{{ route('logout') }}">
            @csrf
                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                    {{ __('ログアウト') }}
                </x-dropdown-link>
            </form>
        </li>
    </ul>
    <nav id="nav">
        <ul>
            <li><a class="link" href="{{url('/home')}}">ホーム</a></a></li>
            <li><a class="link" href="{{url('/datalist')}}">日付別一覧</a></li>
            <li><a class="link" href="{{url('/individual')}}">個人別実績一覧</a></li>
            <li><a class="link" href="{{url('/userlist')}}">登録者一覧</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
            @csrf
                <x-dropdown-link class="link" :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                    {{ __('ログアウト') }}
                </x-dropdown-link>
            </form>
        </li>
        </ul>
    </nav>
    <div id="hamburger">
        <span class="inner_line" id="line1"></span>
        <span class="inner_line" id="line2"></span>
        <span class="inner_line" id="line3"></span>
    </div>
</div>