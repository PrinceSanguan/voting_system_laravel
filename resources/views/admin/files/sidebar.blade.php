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
                        <a href="{{route('admin.index')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>

                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-item">
                        <a href="{{route('admin.organization')}}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user-check"></i>
                            <div>Organization Management</div>
                            
                            <i class="sidenav-icon feather icon-chevrons-right"></i>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                
                            </li>
                            <!-- <li class="sidenav-item">
                                <a href="" class="sidenav-link">
                                    <i class="sidenav-icon feather icon-chevrons-right"></i>
                                    <div>Organizations Account</div>
                                </a>
                            </li> -->
                        </ul>
                    </li>
                    <!-- Forms & Tables -->
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-item">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-align-justify"></i>
                            <div>User Account Management</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                <a href="{{ route('admin.organization.account') }}" class="sidenav-link">
                                    <i class="sidenav-icon feather icon-chevrons-right"></i>
                                    <div>Create Sub-admin Account</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{ route('admin.update-account') }}" class="sidenav-link">
                                    <i class="sidenav-icon feather icon-chevrons-right"></i>
                                    <div>My Account</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>