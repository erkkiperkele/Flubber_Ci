<title>Flubber Inc.</title>
<?php LoadCSSBundle() ?>
<body>
<nav class='navbar navbar-default navbar-fixed-top'  style='background-color:#e67e22' role='navigation'>
  <div class='container-fluid'>
    <h1>Welcome to Flubber </h1>
  </div>
</nav>
<div style="margin-top: 5%"></div>
    <section class="container content-section text-right col-md-4 col-xs-4 col-md-offset-1 col-xs-offset-1">
      <h1>Welcome to Flubber</h1>
      <?php echo validation_errors(); ?>
      <?php echo form_open('/flubber/login'); ?>
        <div class="input-group input-group-md">
          <span class="input-group-addon">Email:</span>
          <input type="text" class="form-control" name="username" id="username" placeholder="Enter your Email">
        </div>
        <br/>
        <div class="input-group input-group-md">
          <span class="input-group-addon">Password:</span>
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password">
        </div>
        <br/>
        <button type="submit" class="btn btn-default" value="login">Login</button>
    </form>
  </section>
  <section class="container content-section text-left col-md-6 col-xs-6">
    <h2>Register</h2>
    <?php echo validation_errors(); ?>
    <?php echo form_open('register'); ?>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter a user's firstname:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter user's firstname">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter a user's date of birth:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter user's date of birth">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter a user's email address:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter user's email address">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter your firstname:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter your firstname">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter your lastname:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter your lastname">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter your date of birth:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter your date of birth">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter your email address:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter your email address">
    </div><br/>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter your password:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter your password">
    </div><br/>
    <br/>
    <h2> If you were provided a secret key from a friend...</h2>
    <div class="input-group input-group-md">
      <span class="input-group-addon">Enter the secret key:</span>
      <input type="text" class="form-control" id="username" placeholder="Enter secret key">
    </div><br/>

  </section>
</body>
<?php LoadJSBundle() ?>

</script>