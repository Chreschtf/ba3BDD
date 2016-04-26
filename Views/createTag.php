        </p>
        <input type='hidden' name='uid' value=<?php echo $uid ?> >
        <input type='hidden' name='eid' value=<?php echo $eid ?> >
        <p> 
            <input type='submit' name='useTag' value='Submit'>
        </p>
    </form>
    <form action='?action=createTag' method='post' class='form-control'>
        <p> 
            Create a new Tag : <input type='text' name='tag_name' required/>
            <!--<span class='error'>* <?php echo $comment_text_error;?></span><br>  -->
        </p>
        <input type='hidden' name='uid' value=<?php echo $uid ?> >
        <input type='hidden' name='eid' value=<?php echo $eid ?> >
        <p>
            <input type='submit' name='createTag' value='Submit'>
        </p>
    </form> 
</div>