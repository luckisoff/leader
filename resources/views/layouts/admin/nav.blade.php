<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="@if(Auth::guard('admin')->user()->picture){{Auth::guard('admin')->user()->picture}} @else {{asset('admin-css/dist/img/avatar.png')}} @endif" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::guard('admin')->user()->name}}</p>
                <a href="{{route('admin.profile')}}">{{ tr('admin') }}</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <li id="dashboard">
              <a href="{{route('admin.dashboard')}}">
                <i class="fa fa-dashboard"></i> <span>{{tr('dashboard')}}</span>
              </a>
              
            </li>

            <li class="treeview" id="users">

                <a href="#">
                    <i class="fa fa-user"></i> <span>{{tr('users')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="add-user"><a href="{{route('admin.add.user')}}"><i class="fa fa-circle-o"></i>{{tr('add_user')}}</a></li>
                    <li id="view-user"><a href="{{route('admin.users')}}"><i class="fa fa-circle-o"></i>{{tr('view_users')}}</a></li>
                    <li id="winner-winner"><a href="{{route('live-quiz-winners')}}"><i class="fa fa-circle-o"></i>{{tr('Live Quiz Winner')}}</a></li>
                </ul>
    
            </li>

            <li class="treeview" id="categories">
                <a href="{{route('admin.categories')}}">
                    <i class="fa fa-suitcase"></i> <span>{{tr('categories')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="add-category"><a href="{{route('admin.add.category')}}"><i class="fa fa-circle-o"></i>{{tr('add_category')}}</a></li>
                    <li id="view-categories"><a href="{{route('admin.categories')}}"><i class="fa fa-circle-o"></i>{{tr('view_categories')}}</a></li>
                </ul>

            </li>
            
             <li class="treeview" id="stories">
                <a href="{{route('admin.stories')}}">
                    <i class="fa fa-suitcase"></i> <span>{{tr('stories')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="add-story"><a href="{{route('admin.add.story')}}"><i class="fa fa-circle-o"></i>{{tr('add_story')}}</a></li>
                    <li id="view-stories"><a href="{{route('admin.stories')}}"><i class="fa fa-circle-o"></i>{{tr('view_stories')}}</a></li>
                </ul>

            </li>

            <li class="treeview" id="videos">
                <a href="{{route('admin.videos')}}">
                    <i class="fa fa-video-camera"></i> <span>{{tr('videos')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="add-video"><a href="{{route('admin.add.video')}}"><i class="fa fa-circle-o"></i>{{tr('add_video')}}</a></li>
                    <li id="view-videos"><a href="{{route('admin.videos')}}"><i class="fa fa-circle-o"></i>{{tr('view_videos')}}</a></li>
                </ul>

            </li>
            
             <li class="treeview" id="counters">
                <a href="{{route('admin.videos')}}">
                    <i class="fa fa-clock-o"></i> <span>{{tr('counters')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li id="add-video"><a href="{{route('addcounter')}}"><i class="fa fa-circle-o"></i>{{tr('add_counter')}}</a></li>
                    <li id="view-videos"><a href="{{route('counter')}}"><i class="fa fa-circle-o"></i>{{tr('view_counters')}}</a></li>
                </ul>

            </li>

            <li id="settings">
                <a href="{{route('admin.settings')}}">
                    <i class="fa fa-gears"></i> <span>{{tr('settings')}}</span>
                </a>
            </li>

            <li class="treeview" id="pages">
                <a href="{{route('viewPages')}}">
                    <i class="fa fa-book"></i> <span>{{tr('pages')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_page"><a href="{{route('addPage')}}"><i class="fa fa-circle-o"></i>{{tr('add_page')}}</a></li>
                    <li id="page_index"><a href="{{route('viewPages')}}"><i class="fa fa-circle-o"></i>{{tr('view_pages')}}</a></li>
                </ul>
            </li>

            <li class="treeview" id="banner">
                <a href="">
                    <i class="fa fa-bookmark"> </i>  <span>{{tr('Banner')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_banner"><a href="{{route('banner.show-banner')}}"><i class="fa fa-circle-o"></i>Add Banner </a></li>
                    <li id="show_banner"><a href="{{route('banner.view-banner')}}"><i class="fa fa-circle-o"></i>View Banner</a></li>
                </ul>
            </li>

            <li class="treeview" id="judge">
                <a href="">
                    <i class="fa fa-users"> </i>  <span>{{tr('Judge')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_judge"><a href="{{route('judge.show-judge')}}"><i class="fa fa-circle-o"></i>Add Judge </a></li>
                    <li id="show_judge"><a href="{{route('judge.view-judge')}}"><i class="fa fa-circle-o"></i>View Judge</a></li>
                </ul>
            </li>

            <li class="treeview" id="sponser">
                <a >
                    <i class="fa fa-shopping-basket"></i><span>{{tr('Sponser')}}</span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_sponser"><a href="{{route('sponser.show-sponser-form')}}"><i class="fa fa-circle-o"></i>Add Sponser </a></li>
                    <li id="show_sponser"><a href="{{route('sponser.view-sponser')}}"><i class="fa fa-circle-o"></i>View Sponser</a></li>
                </ul>
            </li>

            <li class="treeview" id="Apps">
                    <a >
                        <i class="fa fa-mobile"></i><span>{{tr('Apps')}}</span><i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="add_sponser"><a href="{{route('createapp')}}"><i class="fa fa-circle-o"></i>Add App </a></li>
                        <li id="show_sponser"><a href="{{route('app')}}"><i class="fa fa-circle-o"></i>View Apps</a></li>
                    </ul>
                </li>

            <li class="treeview" id="audition">
                <a >
                    <i class="fa fa-file"></i><span>{{tr('Audition Registration')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_audition"><a href="{{route('audition.show-audition-form')}}"><i class="fa fa-circle-o"></i>Add Audition User </a></li>
                    <li id="show_audition"><a href="{{route('audition.view-audition')}}"><i class="fa fa-circle-o"></i>View Audition User</a></li>
                </ul>
            </li>

            <li class="treeview" id="location">
                <a href="">
                    <i class="fa fa-map-marker" style="color:darkred;"> </i>  <span>{{tr('Audition Location')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_location"><a href="{{route('location.show-location')}}"><i class="fa fa-circle-o"></i>Add Location </a></li>
                    <li id="show_location"><a href="{{route('location.view-location')}}"><i class="fa fa-circle-o"></i>View Location</a></li>
                </ul>
            </li>

            <li class="treeview" id="news">
                <a >
                    <i class="fa fa-book"></i><span>{{tr('News')}}</span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li id="add_news"><a href="{{route('news.show-news-form')}}"><i class="fa fa-circle-o"></i>Add News </a></li>
                    <li id="show_news"><a href="{{route('news.view-news')}}"><i class="fa fa-circle-o"></i>View News</a></li>
                </ul>
            </li>


            <li id="profile">
                <a href="{{route('admin.profile')}}">
                    <i class="fa fa-diamond"></i> <span>{{tr('account')}}</span>
                </a>
            </li>

            <li id="help">
                <a href="{{route('admin.help')}}">
                    <i class="fa fa-question-circle"></i> <span>{{tr('help')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.logout')}}">
                    <i class="fa fa-sign-out"></i> <span>{{tr('sign_out')}}</span>
                </a>
            </li>

        </ul>

    </section>

    <!-- /.sidebar -->

</aside>