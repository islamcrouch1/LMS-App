<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard' , app()->getLocale())}}" class="brand-link">
      <img src="{{ asset('newasset/images/illustration/student/128/white.svg') }}" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ALMS Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('storage/' . Auth::user()->profile) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="{{route('dashboard' , app()->getLocale())}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>

          @if (auth()->user()->hasPermission('users-read'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                All Users
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">
                  {{ $userscount - 1}}
                </span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url(app()->getLocale() . '/dashboard/users' )}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('users.trashed' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Trashed Users</p>
                  </a>
                </li>
            </ul>
          </li>
          @endif



          @if (auth()->user()->hasPermission('roles-read'))          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Roles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('roles.index' , app()->getLocale())}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles for users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('roles.trashed' , app()->getLocale())}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trashed Roles</p>
                </a>
              </li>
            </ul>
          </li>
          @endif






          @if (auth()->user()->hasPermission('settings-read'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('settings.social_links' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Social Links</p>
                  </a>
                </li>
            </ul>
          </li>
          @endif


          @if (auth()->user()->hasPermission('countries-read'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Countries
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('countries.index' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Countries</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('countries.trashed' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Trashed Countries</p>
                  </a>
                </li>
            </ul>
          </li>
          @endif

          @if (auth()->user()->hasPermission('learning_systems-read'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Learning Systems
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('learning_systems.index' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Learning Systems</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('learning_systems.trashed' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Trashed Systems</p>
                  </a>
                </li>
                @if (auth()->user()->hasPermission('stages-read'))
                <li class="nav-item">
                  <a href="{{route('stages.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>stages</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('stages.trashed' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Trashed Stages</p>
                    </a>
                  </li>
                  @endif
                  @if (auth()->user()->hasPermission('ed_classes-read'))
                  <li class="nav-item">
                    <a href="{{route('ed_classes.index' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Classes</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('ed_classes.trashed' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Trashed Classes</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermission('courses-read'))
                    <li class="nav-item">
                      <a href="{{route('courses.index' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Courses</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('courses.trashed' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Trashed Courses</p>
                        </a>
                      </li>
                      @endif

                      @if (auth()->user()->hasPermission('chapters-read'))
                      <li class="nav-item">
                        <a href="{{route('chapters.index' , app()->getLocale())}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>chapters</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{route('chapters.trashed' , app()->getLocale())}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Trashed chapters</p>
                          </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('lessons-read'))
                        <li class="nav-item">
                          <a href="{{route('lessons.index' , app()->getLocale())}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>lessons</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('lessons.trashed' , app()->getLocale())}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Trashed lessons</p>
                            </a>
                          </li>
                          @endif
            </ul>
          </li>
          @endif
          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>