<div class="container">
    
    <form action="?action=login" method="post" class="form-signin">
        <h2 class="form-signin-heading">Login Page</h2>
        <p>Welcome, please enter your credentials.</p>
        <?php 
        if ($notification != "")
            echo "<div style='color:#FF0000'>" . $notification . "</div>";
         ?>
        
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" class="form-control" name="username" placeholder="Username" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        
        <div class="checkbox">
            <label>
            <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        
        <p></p><p> No account yet? <a href="?action=signUp">Click here to sign up.</a>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connect</button>
    </form>
    
</div> <!-- /container -->
