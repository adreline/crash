<div class="post">
    <img src="@yield($img)" alt="">
    <div class="content">
      <h3>Epic post</h3>
        @yield($content)
      <div class="container">
        <p>Replies: <mark class="info">@yield($comments)</mark> </p>
        <p>Kudos: <mark class="info">@yield($kudos)</mark> </p>
        <p> <a href="{route(reply)}"> <mark class="success">reply</mark> </a> </p>
      </div>
  </div>
</div>