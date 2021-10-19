@extends('layouts.base')

@section('title','打刻画面')

@section('content')
    <p class="user_name">{{$user->name}}さん</p>
    <punchin-component v-bind:user_id="{{$user->id}}"></punchin-component>
    <calendar-component></calendar-component>

@endsection