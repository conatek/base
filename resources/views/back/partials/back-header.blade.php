<div class="app-header header-shadow" style="border-bottom: 4px solid #ff4600;">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ms-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            {{-- <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon">
                        <span></span>
                    </button>
                </div>
                <button class="btn-close"></button>
            </div>
            <ul class="header-megamenu nav">
                <li class="nav-item">
                    <a href="javascript:void(0);" data-bs-placement="bottom" rel="popover-focus"
                        data-offset="300" data-toggle="popover-custom" class="nav-link">
                        <i class="nav-link-icon pe-7s-gift"></i>
                        Mega Menu
                        <i class="fa fa-angle-down ms-2 opacity-5"></i>
                    </a>
                    <div class="rm-max-width">
                        <div class="d-none popover-custom-content">
                            <div class="dropdown-mega-menu">
                                <div class="grid-menu grid-menu-3col">
                                    <div class="g-0 row">
                                        <div class="col-sm-6 col-xl-4">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item"> Overview</li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-inbox"></i>
                                                        <span> Contacts</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-book"></i>
                                                        <span> Incidents</span>
                                                        <div class="ms-auto badge rounded-pill bg-danger">5</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        <i class="nav-link-icon lnr-picture"></i>
                                                        <span> Companies</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a disabled="" href="javascript:void(0);" class="nav-link disabled">
                                                        <i class="nav-link-icon lnr-file-empty"></i>
                                                        <span> Dashboards</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item"> Favourites</li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link"> Reports Conversions</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        Quick Start
                                                        <div class="ms-auto badge bg-success">New</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Users &amp; Groups</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Proprieties</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item">Sales &amp; Marketing</li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Queues</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Resource Groups</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        Goal Metrics
                                                        <div class="ms-auto badge bg-warning">3</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Campaigns</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="btn-group nav-item">
                    <a class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge rounded-pill bg-danger ms-0 me-2">4</span>
                        Settings
                        <i class="fa fa-angle-down ms-2 opacity-5"></i>
                    </a>
                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-secondary">
                                <div class="menu-header-image opacity-5" style="background-image: url('images/dropdown-header/abstract2.jpg');"></div>
                                <div class="menu-header-content">
                                    <h5 class="menu-header-title">Overview</h5>
                                    <h6 class="menu-header-subtitle">Dropdown menus for everyone</h6>
                                </div>
                            </div>
                        </div>
                        <div class="scroll-area-xs">
                            <div class="scrollbar-container">
                                <h6 tabindex="-1" class="dropdown-header">Key Figures</h6>
                                <button type="button" tabindex="0" class="dropdown-item">Service Calendar</button>
                                <button type="button" tabindex="0" class="dropdown-item">Knowledge Base</button>
                                <button type="button" tabindex="0" class="dropdown-item">Accounts</button>
                                <div tabindex="-1" class="dropdown-divider"></div>
                                <button type="button" tabindex="0" class="dropdown-item">Products</button>
                                <button type="button" tabindex="0" class="dropdown-item">Rollup Queries</button>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn nav-item">
                                <button class="btn-wide btn-shadow btn btn-danger btn-sm">Cancel</button>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="dropdown nav-item">
                    <a aria-haspopup="true" data-bs-toggle="dropdown" class="nav-link" aria-expanded="false">
                        <i class="nav-link-icon pe-7s-settings"></i>
                        Projects
                        <i class="fa fa-angle-down ms-2 opacity-5"></i>
                    </a>
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-rounded dropdown-menu-lg rm-pointers dropdown-menu">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-success">
                                <div class="menu-header-image opacity-1" style="background-image: url('images/dropdown-header/abstract3.jpg');"></div>
                                <div class="menu-header-content text-start">
                                    <h5 class="menu-header-title">Overview</h5>
                                    <h6 class="menu-header-subtitle">Unlimited options</h6>
                                    <div class="menu-header-btn-pane">
                                        <button class="me-2 btn btn-dark btn-sm">Settings</button>
                                        <button class="btn-icon btn-icon-only btn btn-warning btn-sm">
                                            <i class="pe-7s-config btn-icon-wrapper"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <i class="dropdown-icon lnr-file-empty"></i>
                            Graphic Design
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <i class="dropdown-icon lnr-file-empty"></i>
                            App Development
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <i class="dropdown-icon lnr-file-empty"></i>
                            Icon Design
                        </button>
                        <div tabindex="-1" class="dropdown-divider"></div>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <i class="dropdown-icon lnr-file-empty"></i>
                            Miscellaneous
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <i class="dropdown-icon lnr-file-empty"></i>
                            Frontend Dev
                        </button>
                    </div>
                </li>
            </ul> --}}
        </div>
        <div class="app-header-right">
            {{-- <div class="header-dots">
                <div class="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false"
                        data-bs-toggle="dropdown" class="p-0 me-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-primary"></span>
                            <i class="icon text-primary ion-android-apps"></i>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-plum-plate">
                                <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract4.jpg');"></div>
                                <div class="menu-header-content text-white">
                                    <h5 class="menu-header-title">Grid Dashboard</h5>
                                    <h6 class="menu-header-subtitle">Easy grid navigation inside dropdowns</h6>
                                </div>
                            </div>
                        </div>
                        <div class="grid-menu grid-menu-xl grid-menu-3col">
                            <div class="g-0 row">
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-world icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Automation
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-piggy icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Reports
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-config icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Settings
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-browser icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Content
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-hourglass icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Activity
                                    </button>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                        <i class="pe-7s-world icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                                        Contacts
                                    </button>
                                </div>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn text-center nav-item">
                                <button class="btn-shadow btn btn-primary btn-sm">Follow-ups</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button" aria-haspopup="true" aria-expanded="false"
                        data-bs-toggle="dropdown" class="p-0 me-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-danger"></span>
                            <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                            <span class="badge badge-dot badge-dot-sm bg-danger">Notifications</span>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header mb-0">
                            <div class="dropdown-menu-header-inner bg-deep-blue">
                                <div class="menu-header-image opacity-1" style="background-image: url('images/dropdown-header/city3.jpg');"></div>
                                <div class="menu-header-content text-dark">
                                    <h5 class="menu-header-title">Notifications</h5>
                                    <h6 class="menu-header-subtitle">You have
                                        <b>21</b> unread messages
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered p-3">
                            <li class="nav-item">
                                <a role="tab" class="nav-link active"
                                    data-bs-toggle="tab" href="#tab-messages-header">
                                    <span>Messages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" data-bs-toggle="tab" href="#tab-events-header">
                                    <span>Events</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" data-bs-toggle="tab" href="#tab-errors-header">
                                    <span>System Errors</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div class="notifications-box">
                                                <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                    <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">All Hands Meeting</h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <p>Yet another one, at
                                                                    <span class="text-success">15:00 PM</span>
                                                                </p>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">
                                                                    Build the production release
                                                                    <span class="badge bg-danger ms-2">NEW</span>
                                                                </h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-primary vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">
                                                                    Something not important
                                                                    <div class="avatar-wrapper mt-2 avatar-wrapper-overlap">
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/12.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/2.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/3.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/4.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/5.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/9.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/7.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm">
                                                                            <div class="avatar-icon">
                                                                                <img src="images/avatars/8.jpg" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                                            <div class="avatar-icon">
                                                                                <i>+</i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-info vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">This dot has an info state</h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">All Hands Meeting</h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <p>Yet another one, at
                                                                    <span class="text-success">15:00 PM</span>
                                                                </p>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">
                                                                    Build the production release
                                                                    <span class="badge bg-danger ms-2">NEW</span>
                                                                </h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="vertical-timeline-item dot-dark vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <h4 class="timeline-title">This dot has a dark state</h4>
                                                                <span class="vertical-timeline-element-date"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-events-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="p-3">
                                            <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-success"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">All Hands Meeting</h4>
                                                            <p>
                                                                Lorem ipsum dolor sic amet, today at
                                                                <a href="javascript:void(0);">12:00 PM</a>
                                                            </p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-warning"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <p>Another meeting today, at
                                                                <b class="text-danger">12:00 PM</b>
                                                            </p>
                                                            <p>Yet another one, at
                                                                <span class="text-success">15:00 PM</span>
                                                            </p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-danger"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">Build the production release</h4>
                                                            <p>
                                                                Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                            labore et dolore magna elit enim at minim veniam quis nostrud
                                                            </p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-primary"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title text-success">Something not important</h4>
                                                            <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis nostrud</p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-success"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">All Hands Meeting</h4>
                                                            <p>
                                                                Lorem ipsum dolor sic amet, today at
                                                                <a href="javascript:void(0);">12:00 PM</a>
                                                            </p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-warning"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <p>Another meeting today, at
                                                                <b class="text-danger">12:00 PM</b>
                                                            </p>
                                                            <p>Yet another one, at
                                                                <span class="text-success">15:00 PM</span>
                                                            </p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-danger"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title">Build the production release</h4>
                                                            <p>
                                                                Lorem ipsum dolor sit amit,consectetur eiusmdd tempor incididunt ut
                                                            labore et dolore magna elit enim at minim veniam quis nostrud
                                                            </p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="vertical-timeline-item vertical-timeline-element">
                                                    <div>
                                                        <span class="vertical-timeline-element-icon bounce-in">
                                                            <i class="badge badge-dot badge-dot-xl bg-primary"></i>
                                                        </span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                            <h4 class="timeline-title text-success">Something not important</h4>
                                                            <p>Lorem ipsum dolor sit amit,consectetur elit enim at minim veniam quis nostrud</p>
                                                            <span class="vertical-timeline-element-date"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-errors-header" role="tabpanel">
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <div class="no-results pt-3 pb-0">
                                            <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                                                <span class="swal2-success-line-tip"></span>
                                                <span class="swal2-success-line-long"></span>
                                                <div class="swal2-success-ring"></div>
                                                <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                                                <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                                            </div>
                                            <div class="results-subtitle">All caught up!</div>
                                            <div class="results-title">There are no system errors!</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider nav-item"></li>
                            <li class="nav-item-btn text-center nav-item">
                                <button class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View Latest Changes</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button" data-bs-toggle="dropdown" class="p-0 me-2 btn btn-link">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-focus"></span>
                            <span class="language-icon opacity-8 flag large DE"></span>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner pt-4 pb-4 bg-focus">
                                <div class="menu-header-image opacity-05" style="background-image: url('images/dropdown-header/city2.jpg');"></div>
                                <div class="menu-header-content text-center text-white">
                                    <h6 class="menu-header-subtitle mt-0"> Choose Language</h6>
                                </div>
                            </div>
                        </div>
                        <h6 tabindex="-1" class="dropdown-header"> Popular Languages</h6>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <span class="me-3 opacity-8 flag large US"></span>
                            USA
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <span class="me-3 opacity-8 flag large CH"></span>
                            Switzerland
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <span class="me-3 opacity-8 flag large FR"></span>
                            France
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <span class="me-3 opacity-8 flag large ES"></span>
                            Spain
                        </button>
                        <div tabindex="-1" class="dropdown-divider"></div>
                        <h6 tabindex="-1" class="dropdown-header">Others</h6>
                        <button type="button" tabindex="0" class="dropdown-item active">
                            <span class="me-3 opacity-8 flag large DE"></span>
                            Germany
                        </button>
                        <button type="button" tabindex="0" class="dropdown-item">
                            <span class="me-3 opacity-8 flag large IT"></span>
                            Italy
                        </button>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button" aria-haspopup="true" data-bs-toggle="dropdown" data-bs-placement="bottom"
                        title="Tooltip on bottom" aria-expanded="false" class="p-0 btn btn-link dd-chart-btn">
                        <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                            <span class="icon-wrapper-bg bg-success"></span>
                            <i class="icon text-success ion-ios-analytics"></i>
                        </span>
                    </button>
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                        <div class="dropdown-menu-header">
                            <div class="dropdown-menu-header-inner bg-premium-dark">
                                <div class="menu-header-image" style="background-image: url('images/dropdown-header/abstract4.jpg');"></div>
                                <div class="menu-header-content text-white">
                                    <h5 class="menu-header-title">Users Online</h5>
                                    <h6 class="menu-header-subtitle">Recent Account Activity Overview</h6>
                                </div>
                            </div>
                        </div>
                        <div class="widget-chart">
                            <div class="widget-chart-content">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-9 bg-focus"></div>
                                    <i class="lnr-users text-white"></i>
                                </div>
                                <div class="widget-numbers">
                                    <span>344k</span>
                                </div>
                                <div class="widget-subheading pt-2">
                                    Profile views since last login
                                </div>
                                <div class="widget-description text-danger">
                                    <span class="pe-1">
                                        <span>176%</span>
                                    </span>
                                    <i class="fa fa-arrow-left"></i>
                                </div>
                            </div>
                            <div class="widget-chart-wrapper">
                                <div id="dashboard-sparkline-carousel-3-pop"></div>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item-divider mt-0 nav-item"></li>
                            <li class="nav-item-btn text-center nav-item">
                                <button class="btn-shine btn-wide btn-pill btn btn-warning btn-sm">
                                    <i class="fa fa-cog fa-spin me-2"></i>
                                    View Details
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
            <div class="header-btn-lg pe-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    @if (auth()->user()->image_url)
                                        <img width="42" class="rounded-circle" src="{{ auth()->user()->image_url }}" alt="">
                                    @else
                                        <img width="42" class="rounded-circle" src="{{ asset('images/default-profile.jpeg') }}" alt="">
                                    @endif
                                    <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            <div class="menu-header-image opacity-2" style="background-image: url('images/dropdown-header/city3.jpg');"></div>
                                            <div class="menu-header-content text-start">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left me-3">
                                                            @if (auth()->user()->image_url)
                                                                <img width="42" class="rounded-circle" src="{{ auth()->user()->image_url }}" alt="">
                                                            @else
                                                                <img width="42" class="rounded-circle" src="{{ asset('images/default-profile.jpeg') }}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">{{ auth()->user()->name }}</div>
                                                            <div class="widget-subheading opacity-8">{{ auth()->user()->company->company_name }}</div>
                                                        </div>
                                                        <div class="widget-content-right me-2">
                                                            <button class="btn-pill btn-shadow btn-shine btn btn-focus" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">

                                                                Salir
                                                            </button>

                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="scroll-area-xs" style="height: 150px;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item">Activity</li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        Chat
                                                        <div class="ms-auto badge rounded-pill bg-info">8</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Recover Password</a>
                                                </li>
                                                <li class="nav-item-header nav-item">
                                                    My Account
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        Settings
                                                        <div class="ms-auto badge bg-success">New</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">
                                                        Messages
                                                        <div class="ms-auto badge bg-warning">512</div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">Logs</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="nav flex-column">
                                        <li class="nav-item-divider mb-0 nav-item"></li>
                                    </ul>
                                    <div class="grid-menu grid-menu-2col">
                                        <div class="g-0 row">
                                            <div class="col-sm-6">
                                                <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                    <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                                                    Message Inbox
                                                </button>
                                            </div>
                                            <div class="col-sm-6">
                                                <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                    <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                    <b>Support Tickets</b>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav flex-column">
                                        <li class="nav-item-divider nav-item"></li>
                                        <li class="nav-item-btn text-center nav-item">
                                            <button class="btn-wide btn btn-primary btn-sm"> Open Messages</button>
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ms-3 header-user-info">
                            <div class="widget-heading"> {{ auth()->user()->name }}</div>
                            {{-- <div class="widget-subheading"> Rol: ADMINISTRADOR</div> --}}
                            <div class="widget-subheading"> ROLES: {{ auth()->user()->roles->pluck('name')->map(fn($value) => Str::upper($value))->join(', ') }}</div>
                        </div>

                        {{-- <div class="widget-content-right header-user-info ms-3">
                            <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                <i class="fa text-white fa-calendar pe-1 ps-1"></i>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="header-btn-lg">
                {{-- Este botón remite a: resources\views\back\partials\back-drawer-wrapper.blade.php --}}
                <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
