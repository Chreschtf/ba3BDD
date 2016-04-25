
<div class="wrapper">
    <h2>Write a Comment</h2>

    <!--<div id="notification"><?php echo $notification; ?></div>-->
    <div class="form-createComment" >
        <form action="?action=createComment" method="post" class="form-control">
            <p> 
                Your Comment : <input type="text" name="comment_text" required/>
                <!--<span class="error">* <?php echo $comment_text_error;?></span><br>  -->            
            </p>
            <p>
                <select name='score' >
                     <option value='0' selected='selected'>0</option>
                     <option value="1">1</option>
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>
                     <option value="5">5</option>
                 </select>
            </p>
            <input type='hidden' name='uid' value=<?php echo $uid ?> >
            <input type='hidden' name='eid' value=<?php echo $eid ?> >
            <p>
                <input type="submit" name="from_createComment" value="Submit">
            </p>
        </form>
    </div>
</div>
