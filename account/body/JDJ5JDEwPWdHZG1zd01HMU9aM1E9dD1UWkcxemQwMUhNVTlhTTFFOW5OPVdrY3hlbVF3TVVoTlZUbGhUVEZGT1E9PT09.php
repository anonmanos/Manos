<?
  if(empty($_SESSION["gtnsession"])) {
    // for error
    header('Refresh: 0; url=/');
    exit();
  }
?>
    <div class="page-header">
      <h3>Profile Information</h3>
    </div>
    <form role="form" method="post" action="/account/profile/" class="form-horizontal">
      <input type="hidden" name="_csrf" value="IbxftcgHQqFdqRINDE3SJwv7JYNPL1HpbNWlc=">
      <div class="form-group">
        <label for="email" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-4">
          <input disabled="disabled" type="email" name="email" id="email" placeholder="Email" value="<?=$_SESSION['gtnsessionemail']?>" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Name</label>
        <div class="col-sm-4">
          <input type="text" name="name" id="name" placeholder="Name" value="<?=$_SESSION['gtnsessionname']?>" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="location" class="col-sm-3 control-label">Location</label>
        <div class="col-sm-4">
          <input type="text" name="location" id="location" placeholder="London, England" value="<?=$_SESSION['gtnsessionlocation']?>" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="website" class="col-sm-3 control-label">Website</label>
        <div class="col-sm-4">
          <input type="text" name="website" id="website" placeholder="www.example.org" value="<?=$_SESSION['gtnsessionwebsite']?>" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-4">
          <button type="submit" class="btn btn btn-primary"><i class="fa fa-pencil"></i>Update Profile</button>
        </div>
      </div>
    </form>
    <div class="page-header">
      <h3>Change Password</h3>
    </div>
    <form action="/account/password/" method="POST" class="form-horizontal">
      <input type="hidden" name="_csrf" value="IbxftcgHQqFdqRINDE3SJwv7JYNPL1HpbNWlc=">
      <div class="form-group">
        <label for="currentPassword" class="col-sm-3 control-label">Current Password</label>
        <div class="col-sm-4">
          <input type="password" name="currentPassword" id="currentPassword" placeholder="Current Password" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="newPassword" class="col-sm-3 control-label">New Password</label>
        <div class="col-sm-4">
          <input type="password" name="newPassword" id="newPassword" placeholder="New Password" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="confirmPassword" class="col-sm-3 control-label">Confirm Password</label>
        <div class="col-sm-4">
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-4">
          <button type="submit" class="btn btn btn-primary"><i class="fa fa-lock"></i>Change Password</button>
        </div>
      </div>
    </form>
    <div class="page-header">
      <h3>Delete Account</h3></div>
    <p>You can delete your account, but keep in mind this action is irreversible.</p>
    <form action="/account/delete/" method="POST">
      <input type="hidden" name="_csrf" value="IbxftcgHQqFdqRINDE3SJwv7JYNPL1HpbNWlc=">
      <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>Delete my account</button>
    </form>
    <div class="page-header">
      <h3>Linked Accounts</h3></div>
    <p><a href="/auth/instagram">Link your Instagram account</a></p>
    <p><a href="/auth/google">Link your Google account</a></p>
    <p><a href="/account/unlink/facebook" class="text-danger">Unlink your Facebook account</a></p>
    <p><a href="/auth/twitter">Link your Twitter account</a></p>
    <p><a href="/auth/github">Link your GitHub account</a></p>
    <p><a href="/auth/linkedin">Link your LinkedIn account</a></p>
