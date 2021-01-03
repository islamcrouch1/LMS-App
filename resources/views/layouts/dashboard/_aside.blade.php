<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard' , app()->getLocale())}}" class="brand-link">
      <img src="{{ asset('newasset/images/illustration/student/128/white.svg') }}" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{__('iTeaching Admin')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('storage/images/users/' . Auth::user()->profile) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column pb-5" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="{{route('dashboard' , app()->getLocale())}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{__('Dashboard')}}

              </p>
            </a>
          </li>

          @if (auth()->user()->hasPermission('users-read'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                {{__('All Users')}}
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
                    <p>{{__('Users')}}</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('users.trashed' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Trashed Users')}}</p>
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
                {{__('Roles')}}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('roles.index' , app()->getLocale())}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Roles for users')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('roles.trashed' , app()->getLocale())}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Trashed Roles')}}</p>
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
                {{__('Settings')}}
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                    <a href="{{route('settings.social_links' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Settings')}}</p>
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
                {{__('Countries')}}
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('countries.index' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Countries')}}</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('countries.trashed' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Trashed Countries')}}</p>
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
                {{__('Learning Systems')}}
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('learning-systems.countries' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Learning Systems')}}</p>
                  </a>
                </li>
            </ul>
          </li>
          @endif


          @if (auth()->user()->hasPermission('homework_services-read'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                {{__('Homework Services')}}
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('homework_services.index' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Homework Services')}}</p>
                  </a>
                </li>
            </ul>
          </li>
          @endif





        {{-- @if (auth()->user()->hasPermission('learning_systems-read'))
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                {{__('Learning Systems')}}
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('learning_systems.index' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Learning Systems')}}</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('learning_systems.trashed' , app()->getLocale())}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('Trashed Systems')}}</p>
                  </a>
                </li>
                @if (auth()->user()->hasPermission('stages-read'))
                <li class="nav-item">
                  <a href="{{route('stages.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('stages')}}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('stages.trashed' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Trashed Stages')}}</p>
                    </a>
                  </li>
                  @endif
                  @if (auth()->user()->hasPermission('ed_classes-read'))
                  <li class="nav-item">
                    <a href="{{route('ed_classes.index' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Classes')}}</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('ed_classes.trashed' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Trashed Classes')}}</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermission('courses-read'))
                    <li class="nav-item">
                      <a href="{{route('courses.index' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{__('Courses')}}</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('courses.trashed' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{__('Trashed Courses')}}</p>
                        </a>
                      </li>
                      @endif

                      @if (auth()->user()->hasPermission('chapters-read'))
                      <li class="nav-item">
                        <a href="{{route('chapters.index' , app()->getLocale())}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('chapters')}}</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{route('chapters.trashed' , app()->getLocale())}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('Trashed chapters')}}</p>
                          </a>
                        </li>
                        @endif

                        @if (auth()->user()->hasPermission('lessons-read'))
                        <li class="nav-item">
                          <a href="{{route('lessons.index' , app()->getLocale())}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>{{__('lessons')}}</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('lessons.trashed' , app()->getLocale())}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>{{__('Trashed lessons')}}</p>
                            </a>
                          </li>
                          @endif
                        </ul>
        </li>
        @endif --}}





            @if (auth()->user()->hasPermission('countries-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Live Stream')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('live_stream.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Live Stream')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif


            @if (auth()->user()->hasPermission('categories-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Library')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>

              <ul class="nav nav-treeview">
                @if (auth()->user()->hasPermission('categories-read'))
                <li class="nav-item">
                  <a href="{{route('categories.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Categories')}}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('categories.trashed' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Trashed Categories')}}</p>
                    </a>
                  </li>
                  @endif

                  @if (auth()->user()->hasPermission('products-read'))
                  <li class="nav-item">
                    <a href="{{route('products.index' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Products')}}</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('products.trashed' , app()->getLocale())}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{__('Trashed Products')}}</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasPermission('all_orders-read'))
                    <li class="nav-item">
                      <a href="{{route('all_orders.index' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{__('Orders')}}</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('all_orders.trashed' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{__('Trashed Orders')}}</p>
                        </a>
                      </li>
                      @endif
              </ul>

            </li>
            @endif



            @if (auth()->user()->hasPermission('home_page-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Home Page Sections')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>

              <ul class="nav nav-treeview">
                    @if (auth()->user()->hasPermission('posts-read'))
                    <li class="nav-item">
                      <a href="{{route('posts.index' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{__('news')}}</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('posts.trashed' , app()->getLocale())}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>{{__('Trashed news')}}</p>
                        </a>
                      </li>
                      @endif
                      @if (auth()->user()->hasPermission('ads-read'))
                      <li class="nav-item">
                        <a href="{{route('ads.index' , app()->getLocale())}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('ads')}}</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="{{route('ads.trashed' , app()->getLocale())}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{__('Trashed ads')}}</p>
                          </a>
                        </li>
                        @endif
                        @if (auth()->user()->hasPermission('sponsers-read'))
                        <li class="nav-item">
                          <a href="{{route('sponsers.index' , app()->getLocale())}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>{{__('sponsers')}}</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('sponsers.trashed' , app()->getLocale())}}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>{{__('Trashed sponsers')}}</p>
                            </a>
                          </li>
                          @endif
                          @if (auth()->user()->hasPermission('links-read'))
                          <li class="nav-item">
                            <a href="{{route('links.index' , app()->getLocale())}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('links')}}</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="{{route('links.trashed' , app()->getLocale())}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Trashed links')}}</p>
                              </a>
                            </li>
                            @endif
              </ul>

            </li>
            @endif






            @if (auth()->user()->hasPermission('withdrawals-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Withdrawals')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('withdrawals.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Withdrawals')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif





            @if (auth()->user()->hasPermission('courses_orders-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Courses Orders')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('courses_orders.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Courses Orders')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif


            @if (auth()->user()->hasPermission('homeworks_orders-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p style="font-size:13px">
                  {{__('Homeworks Orders')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('homeworks_orders.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p  style="font-size:13px">{{__('Homeworks Orders')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif


            @if (auth()->user()->hasPermission('reports-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Reports')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('reports.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Reports')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif



            @if (auth()->user()->hasPermission('homeworks_monitor-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p style="font-size:13px">
                  {{__('Monitoring homework')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('homeworks_monitor.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p style="font-size:13px">{{__('Monitoring homework')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif



            @if (auth()->user()->hasPermission('finances-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Finances')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('finances.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Finances')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif


            @if (auth()->user()->hasPermission('teachers-read'))
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  {{__('Teachers')}}
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('teachers.index' , app()->getLocale())}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('Teachers')}}</p>
                    </a>
                  </li>
              </ul>
            </li>
            @endif



     </ul>
    </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
