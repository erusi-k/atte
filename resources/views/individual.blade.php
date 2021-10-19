@extends('layouts.base')

@section('tilte','個人別詳細画面')

@section('content')
<calendar-component v-bind:user_id="{{$user->id}}"></calendar-component>
@endsection