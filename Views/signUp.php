<div class="container">
  <div class="row">
  	<div class="col-md-6">
    
          <form class="form-horizontal" action="?action=signUp" method="post">
          <fieldset>
            <div id="legend">
               <p></p><p></p><p></p><p></p>
              <legend class="">Hi! Please Sign up.</legend>
            </div>
            <div class="control-group">
              <label class="control-label" for="username">Username (length: 6-32)</label>
              <div class="controls">
                <input type="text" id="username" name="nickname" placeholder="" required class="form-control input-lg">
                <p class="help-block"><?php echo $nicknameErr;?></p>
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="password">Password (length: 6-32)</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="" required class="form-control input-lg">
                <p class="help-block"><?php echo $passwordErr;?></p>
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="password_confirm">Password (Confirm)</label>
              <div class="controls">
                <input type="password" id="password_confirm" name="passwordconfirm" required placeholder="" class="form-control input-lg">
                <p class="help-block">Please confirm password</p>
              </div>
            </div>
                     
            <div class="control-group">
              <label class="control-label" for="email">E-mail</label>
              <div class="controls">
                <input type="email" id="email" name="email" placeholder="" required class="form-control input-lg">
                <p class="help-block"><?php echo $emailErr;?></p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button class="btn btn-success" name="form_signup" type="submit">Register</button>
              </div>
            </div>
          </fieldset>
        </form>
    
    </div> 
  </div>
</div>



<!-- <div class="wrapper">
    <h2>Hi! Please Sign up.</h2>

    <div class="form-signup" >
        <form action="?action=signUp" method="post" class="form-control">
            <p>Nickname (length of 6 to 32 characters): <input type="text" name="nickname" required/>
            <span class="error">* <?php //echo $nicknameErr;?></span><br>
            Password (length of 6 to 32 characters): <input type="password" name="password" required/>
            <span class="error">* <?php //echo $passwordErr;?></span><br>
            Confirm password : <input type="password" name="passwordconfirm" required/><br>
            Email : <input type="text" name="email" required/>
            <span class="error">* <?php //echo $emailErr;?></span><br>              
            </p>
            <p><input type="submit" name="form_signup" value="Submit"></p>
        </form>
    </div>
</div> -->