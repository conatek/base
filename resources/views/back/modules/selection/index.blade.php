@extends('back.layouts.app')

@section('content')

<selection-index
    :requisition_types ="{{ $requisition_types }}"
    :collaborators ="{{ $collaborators }}"
    :campuses ="{{ $campuses }}"
    :areas ="{{ $areas }}"
    :positions ="{{ $positions }}"
    :reasons ="{{ $reasons }}"
    :statuses ="{{ $statuses }}"
    :sources ="{{ $sources }}"
></selection-index>

@endsection
