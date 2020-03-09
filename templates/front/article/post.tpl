  {extends file='page.tpl'}
  {block name='page_content'}
  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{$post.title}</h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href="#">{$post.category}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on {$post.date_add}</p>

        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="">

        <hr>

        <p>{$post.article}</p>
        
        <hr>

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form action="{$link->getModuleLink('pp_miniblog', 'post', ['id_post' => $post.id_article])}" method="POST">
              <div class="form-group">
                <textarea name="comment" class="form-control" rows="3"></textarea>
              </div>
              <button name="CommentSubmit" type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        {if isset($comments) }
            {foreach from=$comments item=comment}
            <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
            <div class="media-body">
                <h5 class="mt-0">Commenter Name</h5>
                {$comment.comment}
            </div>
            </div>
            {/foreach}
        {/if}


      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                {*categories*}
                {foreach from=$categories item=category}
                  <li>
                    <a href="#">{$category.name}</a>
                  </li>
                {/foreach}
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
  {/block}