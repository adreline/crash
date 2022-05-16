              <div class="post">
                <img src="<?php echo $image->path; ?>" alt="<?php echo $image->alt; ?>">
                <div class="content">
                  <a href="/crash/athenaeum/<?php echo $publication->uri; ?>"><h3><?php echo $publication->title; ?></h3></a>
                    <p><?php echo $publication->prompt; ?></p>
                  <div class="container">
                    <p>Replies: <mark class="info">0</mark> </p>
                    <p>Kudos: <mark class="info"><?php echo $kudos; ?></mark> </p>
                    <p> <a href="#"> <mark class="success">[reply]</mark> </a> </p>
                  </div>
              </div>
            </div>
