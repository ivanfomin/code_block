
<?php $this->layout('layout', ['title' => 'My Blog']) ?>
<section>
<div class="card">
    <div class="card-header">
        <h2> <?= $this->e($post['title']) ?></h2>
    </div>
    <div class="card-body">
        <?php
        echo $post['content'];
        ?>
    </div>
</div>
<a href="/">На главную</a>
</section>
