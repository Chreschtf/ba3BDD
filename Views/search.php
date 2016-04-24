<div class="wrapper">
    <h2>Search Page</h2>
    <div class="form-signin" >
        <form action="?action=search" method="post" class="form-control">
            <p> Enter what you'd like to look up: <input type="text" name="searchQuery" required/>
            <input type="submit" value="Search">
            <input type="radio" name="all" value="all" checked >All (Users and Establishments)
            <input type="radio" name="all" value="users">Only Users
            <input type="radio" name="all" value="establishments">Only Establishments
            <input type="radio" name="all" value="cafe">Only Cafes
            <input type="radio" name="all" value="restaurant">Only Restaurants
            <input type="radio" name="all" value="hotel">Only Hotels
        </form>
    </div>
</div><!-- #contenu -->