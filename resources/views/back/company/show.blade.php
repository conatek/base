@extends('back.layouts.app')

@section('content')
<company-show
    :company="{{ $company }}"
    :provinces="{{ $provinces }}"
    :company_type="{{ $company_type }}"
    :industry_type="{{ $industry_type }}"
    :identification_type="{{ $identification_type }}"
    :province="{{ $province }}"
    :city="{{ $city }}"
></company-show>

@endsection
