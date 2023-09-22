<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item dropdown user-menu">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
        <img src="{{ url(auth()->user()->photo ?? '') }}" class="user-image img-circle elevation-2 img-profile" alt="User Image">
        <span class="d-none d-md-inline"> 
            {{ auth()->user()->name }}
        </span>  
        </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <li class="user-header card-header">
        <img src="{{ url(auth()->user()->photo ?? '') }}" class="img-circle elevation-2 img-profile" alt="admin">
          <p class="">
            {{ auth()->user()->name }}
            <small>{{ auth()->user()->email }}</small>
          </p>
        </li>
        <li class="user-footer card-footer">
          <a href="/profile" class="btn btn-default btn-flat">
            <i class="fa fa-fw fa-user text-lightblue"></i>
            Profile
          </a>
          <a class="btn btn-default btn-flat float-right " href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fa fa-fw fa-power-off text-red"></i>
          Log Out
          </a>
        </li>
      </ul>
      </li>
      <form id="logout-form" action="/logout" method="post" style="display: none;">
        @csrf
        <input type="hidden">
      </form>
    </ul>
  </nav>