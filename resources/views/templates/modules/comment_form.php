<form action="/crash/athenaeum/comment/post" method="post">
    <input type="hidden" name="id_user" value=<?php echo "\"$p->id\"" ?>>
    <input type="hidden" name="id_publication" value=<?php echo "\"$publication->id\"" ?>>
    <div class="field"><mark class="info">leave a comment</mark></div> 
    <div class="field"><textarea cols="50" rows="10" name="body"></textarea></div> 
    <div class="field"><button type="submit"><mark class="success">[submit]</mark></button></div> 
</form>