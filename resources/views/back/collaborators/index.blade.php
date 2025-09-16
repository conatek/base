@extends('back.layouts.app')

@section('content')

@if (session('success'))
    <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
        <span class="pe-2">
            <i class="fa fa-star"></i>
            <i class="pe-7s-star"></i>
        </span>
        {{ session('success') }}
    </div>
@endif

@php
    $company_id = auth()->user()->company_id;
@endphp


<collaborator-index
    :company_id="{{ $company_id }}"
    {{-- :collaborators="{{ $collaborators }}" --}}
    :absence_types="{{ collect($absence_types) }}"
    :absence_subtypes="{{ collect($absence_subtypes) }}"
></collaborator-index>

@endsection
