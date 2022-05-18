<div class="columns">
    <div class="column is-auto">
        <img class="avatar tiny-avatar" src=<?php echo "\"$pfp->path\"" ?> alt=<?php echo "\"$pfp->alt\"" ?>>
    </div>
    <div class="column">
        <mark class="info"><?php echo $comment_author->username; ?></mark>
        <p><?php echo $comment_body ?></p>
        <?php
        if(isset($p)){
            if($comment_author->id == $p->id) echo "<a href=\"/crash/athenaeum/comment/delete?id_comment=$comment->id_comment&uri_redirect_back=$publication->uri\"><mark class=\"danger\">[delete]</mark></a>"; 
        }
        ?>
    </div>
</div>