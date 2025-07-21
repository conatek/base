@extends('auth.layouts.app')

@section('content')
<div class="app-container app-theme-white body-tabs-shadow bg-white">
    <div class="app-container">
        <div class="h-100">
        {{-- <div> --}}
            <div class="h-100 g-0 row">
                {{-- <div class="d-none d-lg-block col-lg-4 bg-dark" style="background-image: url('images/sidebar/mh-people-lineart.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div> --}}
                <div class="col-12 col-lg-4 bg-dark position-relative min-vh-50 min-lg-vh-100"
                    style="background-image: url('images/sidebar/mh-people-lineart.jpg');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-attachment: local;">
                </div>
                {{-- @include('auth.partials.auth-slider') --}}
                @include('auth.partials.auth-form-login')
            </div>
        </div>
    </div>
</div>
@endsection
