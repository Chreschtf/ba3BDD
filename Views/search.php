

<p></p><p></p>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Enter what you'd like to look up: </a>
    </div>

    <form class="navbar-form navbar-left" role="search" action="?action=search" method="post" >

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
      <ul class="nav navbar-nav">
        
        <select class="form-control" name="choice" >
            <option value="all" selected='selected' >All (Users and Establishments)</option>
            <option value="users">Only Users</option>
            <option value="establishments">Only Establishments</option>
            <option value="bar">Only Bars</option>
            <option value="restaurant">Only Restaurants</option>
            <option value="hotel">Only Hotels</option>
        </select>

      </ul>
      <ul class="nav navbar-nav">
          <a class="navbar-brand" href="#"></a>
      </ul>
        <div class="form-group">
          <input type="search" pattern="([A-Za-z0-9\u00C0-\u024F\u0400-\u04FF\u0374-\u03FF\s])*" name="searchQuery" placeholder="Search" required/>
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      
    </div><!-- /.navbar-collapse -->
    </form>
  </div><!-- /.container-fluid -->
</nav>



<!-- <div class="wrapper">
    <h2>Search Page</h2>
    <div class="form-signin" >
        <form action="?action=search" method="post" class="form-control">
            <p> Enter what you'd like to look up: <input type="text" name="searchQuery" required/>
            <input type="submit" value="Search">
            <input type="radio" name="choice" value="all" checked >All (Users and Establishments)
            <input type="radio" name="choice" value="users">Only Users
            <input type="radio" name="choice" value="establishments">Only Establishments
            <input type="radio" name="choice" value="bar">Only Bars
            <input type="radio" name="choice" value="restaurant">Only Restaurants
            <input type="radio" name="choice" value="hotel">Only Hotels
        </form>
    </div>
</div> -->