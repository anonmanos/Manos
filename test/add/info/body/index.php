<?
  // if(isset($_SESSION["gtnsession"])) {
  //   // for error
  //   header('Refresh: 0; url=/');
  //   exit();
  // }
?>
    <div class="page-header">
      <h3>Add Infomation Test</h3>
    </div>
    <form id="signup-form" method="post" action="/signup/signup/" class="form-horizontal">
      <input type="hidden" name="_csrf" value="Dqgq0FyHipkdZx8gjoddVPdAiAiR8Xy8Y/WrA=">
      <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Name of Test</label>
        <div class="col-sm-7">
          <input type="text" name="name" id="name" placeholder="Name" autofocus class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-7">
          <input type="email" name="email" id="email" placeholder="Email" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="password" class="col-sm-3 control-label">Password</label>
        <div class="col-sm-7">
          <input type="password" name="password" id="password" placeholder="Password" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="confirmPassword" class="col-sm-3 control-label">Confirm Password</label>
        <div class="col-sm-7">
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
          <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i>Signup</button>
        </div>
      </div>
    </form>
  </div>
