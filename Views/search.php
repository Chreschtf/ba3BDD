<div class="wrapper">
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
</div><!-- #contenu -->