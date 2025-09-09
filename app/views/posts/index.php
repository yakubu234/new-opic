<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Posts</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
        <i class="fa fa-pencil"></i> Add Post
      </a>
    </div>
  </div>
  <?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
      <h4 class="card-title"><?php echo $post->title; ?></h4>
      <div class="bg-light p-2 mb-3">
        Written on <?php echo $post->created_at; ?>
      </div>
      <p class="card-text"><?php echo substr($post->body, 0, 100); ?>...</p>
      <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->id; ?>" class="btn btn-dark">More</a>
    </div>
  <?php endforeach; ?>

  <nav>
    <ul class="pagination">
      <?php if ($data['total_pages'] > 1): ?>
        <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
          <li class="page-item <?php echo ($i == $data['current_page']) ? 'active' : ''; ?>">
            <a class="page-link" href="<?php echo URLROOT; ?>/posts/index/<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
      <?php endif; ?>
    </ul>
  </nav>

<?php require APPROOT . '/views/inc/footer.php'; ?>
