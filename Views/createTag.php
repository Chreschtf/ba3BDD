        <!--</p>-->
        <input type='hidden' name='uid' value=<?php echo $uid ?> >
        <input type='hidden' name='eid' value=<?php echo $eid ?> >
        <input type='submit' name='useTag' value='Submit'>
    </form>
    <p></p>
    <p></p>
    <form action='?action=createTag' method='post' class='form-control'>

            Create a new Tag : <input type='text' name='tag_name' required/>
            <!--<span class='error'>* <?php echo $comment_text_error;?></span><br>  -->

        <input type='hidden' name='uid' value=<?php echo $uid ?> >
        <input type='hidden' name='eid' value=<?php echo $eid ?> >
            <input type='submit' name='createTag' value='Submit'>
    </form> 
</div>