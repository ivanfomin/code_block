<?php $this->layout('layout', ['title' => 'My Blog']) ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="create-post" method="post">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $auth->getUserId(); ?>"></input>
                    <div class="form-group">
                        <button class="btn btn-success">Add Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>