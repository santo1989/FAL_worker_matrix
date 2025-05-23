<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="color:#40c47c;">
        <div class="sb-sidenav-menu">
            @can('Admin')
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>

                    <a class="nav-link" href="{{ route('home') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Home
                    </a>
                    <a class="nav-link" href="{{ route('users.show', ['user' => auth()->user()->id]) }}">
                        <div class="sb-nav-link-icon"><i class="far fa-address-card"></i></div>
                        Profile
                    </a>
                    <a class="nav-link" href="{{ route('report.builder') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Report Builder
                    </a>
                    {{-- start library --}}

                    <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutslibrary" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"></div>
                        <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">LIBRARY</h4>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayoutslibrary" aria-labelledby="headinglibrary"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link" href="{{ route('divisions.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Division Management
                            </a>
                            <a class="nav-link" href="{{ route('companies.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Company Management
                            </a>
                            <a class="nav-link" href="{{ route('departments.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Department Management
                            </a>
                            <a class="nav-link" href="{{ route('designations.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Designation Management
                            </a>
                            <a class="nav-link" href="{{ route('sewingProcessList.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Sewing Process List Management
                            </a>
                            <a class="nav-link" href="{{ route('workerEntries.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Operator Assessment Sheet Management
                            </a>
                            {{-- <a class="nav-link" href="">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Entry Form
                            </a> --}}
                        </nav>
                    </div>
                    {{-- end library  --}}

                    {{-- <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">LIBRARY</h4> --}}
                    {{-- Departmental entry --}}
                    <a class="nav-link" href="{{ route('workerEntries.create') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                        Assessment Sheet Entry Form
                    </a>

                    <a class="nav-link" href="{{ route('workerEntries.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                        Operator Assessment Sheet Management
                    </a>

                    @if (auth()->user()->role->name == 'Admin')
                        <a class="nav-link" href="{{ route('training_development') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Training & Development Management
                        </a>
                        <a class="nav-link" href="{{ route('disciplinary_problems') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Disciplinary Problems Management
                        </a>
                    @endif

                     @if (auth()->user()->role_id == 4)
                        <a class="nav-link" href="{{ route('training_development') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Training & Development Management
                        </a>
                        <a class="nav-link" href="{{ route('disciplinary_problems') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Disciplinary Problems Management
                        </a>
                    @endif

                    {{-- start DataEntry --}}

                    <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutsDataEntry" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"></div>
                        <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">Entry Form</h4>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayoutsDataEntry" aria-labelledby="headingDataEntry"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('workerEntries.create') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                Operator Assessment Sheet-ID Entry
                            </a>
                        </nav>
                    </div>
                    {{-- end DataEntry  --}}

                    {{-- user-management start --}}

                    <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                        User Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link " href="{{ route('roles.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                                Role
                            </a>
                            <a class="nav-link " href="{{ route('users.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                                Users
                            </a>

                            <a class="nav-link " href="{{ route('online_user') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Online User List
                            </a>
                        </nav>
                    </div>
                    {{-- user-management end --}}

                </div>
            @endcan


            @can('General')
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>

                    <a class="nav-link " href="{{ route('home') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Home
                    </a>
                    <a class="nav-link " href="{{ route('users.show', ['user' => auth()->user()->id]) }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Profile
                    </a>
                    <a class="nav-link" href="{{ route('sewingProcessList.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Sewing Process List Management
                    </a>
                    <a class="nav-link" href="{{ route('workerEntries.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Operator Assessment Sheet Management
                    </a>


                </div>
            @endcan
            @can('Supervisor')
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>

                    <a class="nav-link" href="{{ route('home') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Home
                    </a>
                    <a class="nav-link" href="{{ route('users.show', ['user' => auth()->user()->id]) }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Profile
                    </a>
                    <a class="nav-link" href="{{ route('report.builder') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Report Builder
                    </a>
                    {{-- start library --}}

                    <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutslibrary" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"></div>
                        <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">LIBRARY</h4>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <a class="nav-link" href="{{ route('sewingProcessList.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Sewing Process List Management
                    </a>
                    <a class="nav-link" href="{{ route('workerEntries.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Operator Assessment Sheet Management
                    </a>

                    <div class="collapse" id="collapseLayoutslibrary" aria-labelledby="headinglibrary"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            <a class="nav-link" href="{{ route('workerEntries.create') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                Operator Assessment Sheet-ID Entry
                            </a>

                        </nav>
                    </div>
                    {{-- end library  --}}

                    @if (auth()->user()->role->name == 'Admin' || auth()->user()->role->name == 'HR')
                        <a class="nav-link" href="{{ route('training_development') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Training & Development Management
                        </a>
                        <a class="nav-link" href="{{ route('disciplinary_problems') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Disciplinary Problems Management
                        </a>
                    @endif

                    {{-- <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">LIBRARY</h4> --}}

                    {{-- start DataEntry --}}

                    <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutsDataEntry" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"></div>
                        <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">Entry Form</h4>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayoutsDataEntry" aria-labelledby="headingDataEntry"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('workerEntries.create') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                Operator Assessment Sheet-ID Entry
                            </a>
                        </nav>
                    </div>
                    {{-- end DataEntry  --}}


                    {{-- user-management start --}}

                    <a class="nav-link collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"></div>
                        <h4 class="sb-sidenav-menu-heading" style="color:#40c47c;">Employee Management</h4>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link " href=" ">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Employee List
                            </a>
                        </nav>
                    </div>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link " href=" ">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Hierarchy Show
                            </a>
                        </nav>
                    </div>

                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link " href=" ">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                User Performance
                            </a>
                        </nav>
                    </div>


                    {{-- user-management end --}}

                </div>
            @endcan

            @can('HR')
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>

                    <a class="nav-link " href="{{ route('home') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Home
                    </a>
                    <a class="nav-link " href="{{ route('users.show', ['user' => auth()->user()->id]) }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Profile
                    </a>
                    <a class="nav-link" href="{{ route('sewingProcessList.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Sewing Process List Management
                    </a>
                    <a class="nav-link" href="{{ route('workerEntries.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Operator Assessment Sheet Management
                    </a>


                </div>
            @endcan
        </div>
        <div class="sb-sidenav-footer " style="color:#40c47c;">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->role->name ?? '' }}

        </div>
    </nav>
</div>
