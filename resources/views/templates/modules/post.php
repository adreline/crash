              <div class="post">
                <img src="<?php echo $image->path; ?>" alt="<?php echo $image->alt; ?>">
                <div class="content">
                  <a href="/crash/athenaeum/<?php echo $publication->uri; ?>"><h3><?php echo $publication->title; ?></h3></a>
                    <p><?php echo $publication->prompt; ?></p>
                  <div class="container">
                    <p>comments: <mark class="info"><?php echo $comments;?></mark> </p>
                    <p>kudos: <mark class="info"><?php echo $kudos; ?></mark> </p>
                  </div>
              </div>
            </div>
