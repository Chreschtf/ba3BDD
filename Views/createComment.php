
<div class="wrapper">
    <h2>Write a Comment</h2>
     <?php 
        if ($notification != "")
            echo "<div style='color:#FF0000'>" . $notification . "</div>";
    ?>

    <div class="form-createComment" >
        <form action="?action=createComment" method="post" class="form-control">


                <textarea name="comment_text" id="textarea" cols="35" rows="5"></textarea>       

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
