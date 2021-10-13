<div class="header">
    <h1 class="header-title"><a href="{{url('/home')}}">Atte</a></h1>
    <ul class="header-list">
        <li><a class="header-list_content" href="{{url('/home')}}">ホーム</a></li>
        <li><a class="header-list_content" href="{{url('/datalist')}}">日付一覧</a></li>
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
    
</div>