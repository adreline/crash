<form action="/crash/athenaeum/comment/post" method="post">
    <input type="hidden" name="id_user" value=<?php echo "\"$p->id\"" ?>>
    <input type="hidden" name="id_publication" value=<?php echo "\"$publication->id\"" ?>>
    <div class="field"><mark class="info">leave a comment</mark></div> 
    <div class="field"><textarea name="body" rows="10"></textarea></div> 
    <div class="field"><button type="submit"><mark class="success">[submit]</mark></button></div> 
</form>