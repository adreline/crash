              <div class="post">
                <img src="img/91026b4802025c0ac38329e7cab1c113.jpg" alt="">
                <div class="content">
                  <h3><?php echo $title; ?></h3>
                    <?php 
                      foreach($paragraphs as $body){
                        echo "<p>$body</p>";
                      }
                    ?>
                  <div class="container">
                    <p>Replies: <mark class="info">7</mark> </p>
                    <p>Kudos: <mark class="info">77</mark> </p>
                    <p> <a href="#"> <mark class="success">reply</mark> </a> </p>
                  </div>
              </div>
            </div>
