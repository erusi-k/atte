@extends('layouts.base')

@section('title','登録ユーザー一覧')

@section('content')

    <h2>登録ユーザー一覧</h2>
    <table>
        <tr>
            <th>登録No.</th>
            <th>お名前</th>
            <th>登録日</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->created_at->format('Y年m月d日')}}</td>
        </tr>
        @endforeach
    </table>
    
    {{$users->links('vendor.pagination.simple-default')}}
@endsection
