<?
  if(isset($_SESSION["gtnsession"])) {
    //users
?>
    <div class="page-header">
      <h3>Contact Form</h3>
    </div>
    <form role="form" method="post" action="/contact/contact/" class="form-horizontal">
      <input type="hidden" name="_csrf" value="uVuXvgcgeL5lPcguNPr1TKdw+gpAVgd2KnzMo=">
      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-8">
          <input type="hidden" name="name" id="name" value="<?=$_SESSION['gtnsessionname']?>">
          <input type="text" value="<?=$_SESSION['gtnsessionname']?>" class="form-control" disabled="disabled">
        </div>
      </div>
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-8">
          <input type="hidden" name="email" id="email" placeholder="Email" value="<?=$_SESSION['gtnsessionemail']?>">
          <input type="email" value="<?=$_SESSION['gtnsessionemail']?>" class="form-control" disabled="disabled">
        </div>
      </div>
      <div class="form-group">
        <label for="message" class="col-sm-2 control-label">Messages</label>
        <div class="col-sm-8">
          <textarea type="text" name="message" id="message" rows="7" autofocus class="form-control"></textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-8">
          <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i>Send</button>
        </div>
      </div>
    </form>
    <?}else{//public?>
      <div class="page-header">
        <h3>Contact Form</h3>
      </div>
      <form role="form" method="POST" action="/contact/contact/" class="form-horizontal">
        <input type="hidden" name="_csrf" value="uVuXvgcgeL5lPcguNPr1TKdw+gpAVgd2KnzMo=">
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-8">
            <input type="text" name="name" id="name" autofocus class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-8">
            <input type="text" name="email" id="email" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label for="message" class="col-sm-2 control-label">Messages</label>
          <div class="col-sm-8">
            <textarea type="text" name="message" id="message" rows="7" class="form-control"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i>Send</button>
          </div>
        </div>
      </form>
      <?}?>
