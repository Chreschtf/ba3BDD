<div class="wrapper">
    <h2>Login Page</h2>
    <p>Welcome, please enter your credentials.</p>

    <!--<div id="notification"><?php echo $notification; ?></div>-->
    <div class="form-signin" >
        <form action="?action=login" method="post" class="form-control">
            <p> Username : <input type="text" name="username" />
            <p> Password : <input type="password" name="password" /></p>
            <p><input type="submit" name="form_login" value="Connect"></p>
        </form>
    </div>
    <p> No account yet? <a href="index.php?action=first">Click here to sign up.</a>
</div><!-- #contenu -->