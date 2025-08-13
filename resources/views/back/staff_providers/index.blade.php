@extends('back.layouts.app')

@section('content')
    <staff-provider-index
        :provider_types="{{ $provider_types }}"
        :provinces="{{ $provinces }}"
        :company_id="{{ $company_id }}"
    ></staff-provider-index>
@endsection
