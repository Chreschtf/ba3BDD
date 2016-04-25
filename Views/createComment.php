
<div class="wrapper">
    <h2>Write a Comment</h2>

    <div class="form-createComment" >
        <form action="?action=createComment" method="post" class="form-control">
            <p> 
                Your Comment : <input type="text" name="comment_text" required/>
                <!--<span class="error">* <?php echo $comment_text_error;?></span><br>  -->            
            </p>
            <p>
                <input type="submit" name="from_createComment" value="Submit">
            </p>
        </form>
    </div>
</div>