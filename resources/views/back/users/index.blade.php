@extends('back.layouts.app')

@section('content')

<user-index
    :current_user_id="{{ $current_user_id }}"
    :current_user_roles="{{ json_encode($current_user_roles) }}"
    :company_id="{{ $company_id }}"
    :roles="{{ $roles }}"
></user-index>

@endsection
