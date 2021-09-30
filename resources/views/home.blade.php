@extends('layouts.base')

@section('title','打刻画面')

@section('content')
    <punchin-component v-bind:user_id="{{$user->id}}"></punchin-component>
    <p>{{$user->name}}</p>
@endsection