<title>Flubber Inc.</title>
<?php LoadCSSBundle() ?>
<body>
<nav class='navbar navbar-default navbar-fixed-top' role='navigation'>
      <div class='container-fluid'>
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class='navbar-header'>
          <a class='navbar-brand' href='/'>Welcome to Flubber</a>
        </div>
      </div><!-- /.container-fluid -->
</nav>
<div style="margin-top: 5%"></div>
    <section class="container text-right content-section col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
      <h2 class='text-left'>Login</h2>
      <?php if(isset($doLogin) && $doLogin) echo validation_errors(); ?>
      <?php echo form_open('/flubber/login'); ?>
          <input type="text" class="form-control" name="username" id="username" placeholder="Enter your Email">
        <br/>
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password">
        <br/>
        <button type="submit" class="btn btn-default" value="login">Login</button>
    </form>
  </section>
  <section class="container content-section text-left col-md-5 col-xs-5 col-md-offset-1 col-xs-offset-1">
    <h2 class='text-right'>Register</h2>
    <?php if(isset($doRegister) && $doRegister) echo validation_errors(); ?>
    <?php echo form_open('/flubber/register'); ?>
      <input type="text" class="form-control" name="username" id="username" placeholder="Enter a user's firstname">
      <br/>
      <input type="text" class="form-control" name="userdob" id="userdob" placeholder="Enter a user's date of birth">
      <br/>
      <input type="text" class="form-control" name="useremail" id="useremail" placeholder="Enter a user's email address">
      <br/>
      <input type="text" class="form-control" name="newfirstname" id="newfirstname" placeholder="Enter your firstname">
      <br/>
      <input type="text" class="form-control" name="newlastname" id="newlastname" placeholder="Enter your lastname">
      <br/>
      <input type="text" class="form-control" name="newdob" id="newdob" placeholder="Enter your date of birth">
      <br/>
      <input type="text" class="form-control" name="newemail" id="newemail" placeholder="Enter your email address">
      <br/>
      <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Enter your password">
      <br/>
      <br/>
      <button type="submit" class="btn btn-default" value="register">Register</button>
    </form>

  </section>
</body>
<?php LoadJSBundle() ?>

</script>