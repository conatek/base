@extends('back.layouts.app')

@section('content')

{{-- {{dd($eps)}} --}}

<absence-index
    :eps="{{ $eps }}"
    :campuses="{{ $campuses }}"
    :absence_types="{{ collect($absence_types) }}"
    :absence_subtypes="{{ json_encode($absence_subtypes) }}"
    :absence_status_types="{{ collect($absence_status_types) }}"
></absence-index>

@endsection
