<?php $this->layout('layout', ['title' => 'My Blog']) ?>
<h3><?=flash()->display();?></h3>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="create-user" method="post">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Repeat Password</label>
                        <input type="text" name="repeat" class="form-control">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Register me</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
