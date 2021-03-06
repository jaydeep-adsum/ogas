<nav class="main-header navbar navbar-expand navbar-light border-bottom" style="background-color: #1C75BC;">
    <!-- Left navbar links -->
    <ul class="navbar-nav toggle-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @if(Auth::user())
                        {{Auth::user()->name}}
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <div class="my-2">
                        <a id="change_password" href="#" class="m-3">Change Password</a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="m-3" href="{{route('logout')}}"
                                         onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </ul>
</nav>
