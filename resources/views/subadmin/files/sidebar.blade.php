<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('Elevotelogo.png') }}" width="50" height="50" class="rounded-circle" alt="">
                    </span>
                    <a href="index.html" class="app-brand-text demo sidenav-text font-weight-normal ml-2">EleVote</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <!-- Dashboards -->
                    <li class="sidenav-item">
                        <a href="{{route('subadmin.index')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>

                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Components</li>
                    
                    <li class="sidenav-item">
                        <a href="{{route('subadmin.election')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-chevrons-right"></i>
                            <div>Election Management</div>
                        </a>
                    </li>

                    <li class="sidenav-item">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-chevrons-right"></i>
                            <div>Ballot Management</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                <a href="{{route('subadmin.position')}}" class="sidenav-link">
                                    <i class="sidenav-icon feather icon-user-check"></i>
                                    <div>Position</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{route('subadmin.partylist')}}" class="sidenav-link">
                                    <i class="sidenav-icon feather icon-users"></i>
                                    <div>Partylist</div>
                                </a>
                            </li>
                            <!-- <li class="sidenav-item">
                                <a href="bui_alert.html" class="sidenav-link">
                                    <i class="sidenav-icon feather icon-chevrons-right"></i>
                                    <div>Registered Voters</div>
                                </a>
                            </li> -->
                            <li class="sidenav-item">
                        <a href="{{route('subadmin.election_type')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-users"></i>
                            <div>Candidate</div>
                        </a>
                    </li>
                        </ul>
                    </li>

                    <!-- UI elements -->

                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-item">
                        <a href="{{route('subadmin.voter-list')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-chevrons-right"></i>
                            <div>Voters Management</div>
                        </a>
                    </li>


                    

                   

                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-item">
                        <a href="{{route('subadmin.voters-turnout')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-chevrons-right"></i>
                            <div>Voters Turnout</div>
                        </a>
                    </li>


                    <!-- Forms & Tables -->
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-item">
                        <a href="{{ route('subadmin.change-account') }}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-chevrons-right"></i>
                            <div>User Account</div>
                        </a>
                    </li>
                </ul>
            </div>