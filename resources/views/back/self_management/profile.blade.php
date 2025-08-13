@extends('back.layouts.app')

@section('content')
    <user-profile
        :user="{{ json_encode($user) }}"
        :roles="{{ json_encode($roles) }}"
    ></user-profile>
@endsection
