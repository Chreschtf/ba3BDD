<div class="wrapper">
    <h2>Hi! Please Sign up.</h2>

    <div class="form-signup" >
        <form action="?action=signUp" method="post" class="form-control">
            <p>Nickname (length of 6 to 32 characters): <input type="text" name="nickname" required/>
            <span class="error">* <?php echo $nicknameErr;?></span><br>
            Password (length of 6 to 32 characters): <input type="password" name="password" required/>
            <span class="error">* <?php echo $passwordErr;?></span><br>
            Confirm password : <input type="password" name="passwordconfirm" required/><br>
            Email : <input type="text" name="email" required/>
            <span class="error">* <?php echo $emailErr;?></span><br>              
            </p>
            <p><input type="submit" name="form_signup" value="Submit"></p>
        </form>
    </div>
</div><!-- #contenu -->