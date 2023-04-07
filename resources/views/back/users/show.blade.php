@extends('back.layouts.app')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-user text-success"></i>
            </div>
            <div>
                Información de Perfil
            </div>
        </div>
        <div class="page-title-actions">
            <button type="button" class="btn-shadow me-3 btn btn-info"
                onclick="event.preventDefault();
                document.getElementById('users-index-form').submit();">
                <i class="fa fa-users"></i>
                Volver a Usuarios
            </button>

            <form id="users-index-form" action="{{ route('users.index') }}" method="GET" class="d-none"></form>
        </div>
    </div>
</div>

@if (session('success'))    
    <div class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
        <span class="pe-2">
            <i class="fa fa-star"></i>
            {{-- <i class="pe-7s-star"></i> --}}
        </span>
        {{ session('success') }}
    </div>
@endif

{{-- <div class="main-card mb-3 card">
    <div class="card-body"> --}}
        <div class="card-shadow-primary profile-responsive card-border mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-focus">
                    <div class="menu-header-image opacity-3" style="background-image: url('images/dropdown-header/city4.jpg');"></div>
                    <div class="menu-header-content btn-pane-right">
                        <div class="avatar-icon-wrapper me-2 avatar-icon-xl">
                            <div class="avatar-icon rounded">
                                {{-- <img src="../images/avatars/12.jpg" alt="Avatar 5"> --}}
                                <img src="{{ asset('/images/avatars/12.jpg') }}" alt="Avatar 5">
                            </div>
                        </div>
                        <div>
                            <h5 class="menu-header-title">{{ $user->name }}</h5>
                            <h6 class="menu-header-subtitle">Implementation Specialist</h6>
                            <h6 class="menu-header-subtitle">{{ $user->email }}</h6>
                        </div>
                        <div class="menu-header-btn-pane">
                            <button class="ladda-button btn btn-pill btn-dark" data-style="slide-right">
                                <span class="ladda-label">Load Click</span>
                                <span class="ladda-spinner"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                {{-- <li class="bg-warm-flame list-group-item"> --}}
                <li class="bg-tempting-azure list-group-item">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left me-3">
                                <div class="icon-wrapper m-0">
                                    <b class="text-primary">
                                        <span>764</span>
                                    </b>
                                </div>
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading text-dark opacity-7">March Totals</div>
                                <div class="widget-subheading opacity-10">
                                    <span class="pe-2">
                                        <b class="text-danger">12</b> new leads,
                                    </span>
                                    <span>
                                        <b class="text-dark">$56,24</b> in sales
                                    </span>
                                </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="icon-wrapper m-0">
                                    <div class="progress-circle-wrapper">
                                        <div class="circle-progress d-inline-block circle-progress-warning">
                                            <small></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="p-0 list-group-item">
                    <div class="grid-menu grid-menu-2col">
                        <div class="g-0 row">
                            <div class="col-sm-6">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                    <i class="lnr-license btn-icon-wrapper btn-icon-lg mb-3"></i>
                                    View Profile
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                    <i class="lnr-map btn-icon-wrapper btn-icon-lg mb-3"></i>
                                    Sales Reports
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                    <i class="lnr-music-note btn-icon-wrapper btn-icon-lg mb-3"></i>
                                    Leads Generated
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                    <i class="lnr-heart btn-icon-wrapper btn-icon-lg mb-3"></i>
                                    Successful Tasks
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    {{-- </div>
</div> --}}
@endsection