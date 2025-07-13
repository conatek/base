@extends('back.layouts.app')

@section('content')
    <home
        :user="{{ json_encode($user) }}"
        :company_id="{{ $user->company_id }}"
        :roles="{{ json_encode($roles) }}"
    ></home>
@endsection

