@extends('layouts.firstbase')

@section('title','ログインページ')
@section('content')
        <!-- Session Status -->
        <x-auth-session-status  :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="errors"  :errors="$errors" />
        
        <form method="POST" action="{{ route('login') }}"  >
            @csrf
            <div class="login">
                <div class="title">
                    <p class="title_content">ログイン</p>
                </div>
                <!-- Emai Address -->
                <div class="input">
                    <x-input  class="input-content"  type="email" name="email" :value="old('email')" placeholder="メールアドレス" required autofocus />
                </div>

                <!-- Password -->
                <div class="input">
                    <input class="input-content" class="btn"
                                    type="password"
                                    name="password"
                                    placeholder="パスワード"
                                    required autocomplete="current-password" />
                </div>
                <div class="btn">
                    <button class="btn_content">
                        {{ __('Log in') }}
                    </button>
                </div>
            </div>
        </form>
        <p class="link">アカウントをお持ちでない方はこちらから</p>
        <a class="link-url" href="{{url('/register')}}">会員登録</a>
@endsection