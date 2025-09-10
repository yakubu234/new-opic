<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
  Written by <?php echo $data['post']->author_name; ?> on <?php echo $data['post']->created_at; ?>
</div>
<p><?php echo $data['post']->body; ?></p>

<?php if(isLoggedIn()): ?>
  <hr>
  <?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
    <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a>
  <?php endif; ?>

  <?php if(isAdmin()) : ?>
    <button id="delete-post-btn" class="btn btn-danger pull-right" data-id="<?php echo $data['post']->id; ?>" data-urlroot="<?php echo URLROOT; ?>">Delete</button>
  <?php endif; ?>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
