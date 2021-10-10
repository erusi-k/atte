@extends('layouts.firstbase')

@section('title','新規登録ページ')
@section('content')

    <!-- Validation Errors -->
    <x-auth-validation-errors class="errors" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="register">
            <div class="title">
                <p class="title_content">新規登録</p>
            </div>
            <!-- Name -->
            <div class="input">
                <x-input class="input-content" type="text" name="name" :value="old('name')" placeholder='名前' required autofocus />
            </div>

            <!-- Email Address -->
            <div class="input">
                <x-input class="input-content"   type="email" name="email" :value="old('email')" placeholder="メールアドレス" required />
            </div>
            <!-- Password -->
            
            <div class="input"> 
                <x-input    class="input-content"
                            type="password"
                            name="password"
                            placeholder="パスワード"
                            required autocomplete="new-password" />
            </div> 

            <!-- Confirm Password -->

            <div class="input">
                <x-input  class="input-content"
                                type="password"
                                name="password_confirmation" placeholder="確認用パスワード" required />
            </div>

            <div class="btn">
                <button class="btn_content">
                    {{ __('新規登録') }}
                </button>
                </div>    
        </div>    
    </form>
    <p class="link">アカウントをお持ちの方はこちらから</p>
    <a class="link-url" href="{{url('/login')}}">ログイン</a>
@endsection
