@extends('layouts.base')

@section('title','個人別実績画面')

@section('content')
<individual-component v-bind:user_id="{{$user->id}}"></-component>
@endsection