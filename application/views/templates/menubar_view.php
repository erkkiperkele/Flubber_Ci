<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Flubber</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="menu">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="groups.php">Groups</a></li>
        <li><a href="friends.php">Friends</a></li>
        <li class="Settings">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Some Random Settings</a></li>
            <li><a href="#">Privacy</a></li>
            <li class="divider"></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      </form>
      <div id="menu-profile" class="navbar-right"></div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>