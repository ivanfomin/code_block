<?php $this->layout('layout', ['title' => 'My Blog']) ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="edit-post" method="post">
                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  name="content"><?= $this->e($post['content']) ?></textarea>
                    </div>
                    <div class=" form-group">
                        <button class="btn btn-success">Edit Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
