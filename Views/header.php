
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Horeca Information Website">
        <meta name="author" content="Küpper Marius - Christian Frantzen">
        <title>Horeca Annuaire</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <link rel="icon" href="../images/horeca.ico">

        <link href="../ba3BDD/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        
        <link href="../ba3BDD/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet">
        <link href="../ba3BDD/css/ie10-viewport-bug-workaround.css" type="text/css" rel="stylesheet">
        <link href="../ba3BDD/css/theme.css" type="text/css" rel="stylesheet">
        <link href="../ba3BDD/css/signin.css" type="text/css" rel="stylesheet">


    </head>

    <body role="document">

        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Annuaire Horeca</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php 
                    if(isset($_COOKIE['username']))
                        echo "<li class='active'><a href='?action=userProfile&user=" . $_COOKIE['username'] . "'>Home</a></li>";
                    else
                        echo "<li class='active'><a href='?index.php'>Home</a></li>";
                ?>
                <li><a href="?action=search">Search</a></li>
                <li><a href="?action=logout">Logout</a></li>

            </ul>
            </div><!--/.nav-collapse -->
        </div>
        </nav>

