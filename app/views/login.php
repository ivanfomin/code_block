<?php $this->layout('layout', ['title' => 'My Blog']) ?>
<h3><?=flash()->display();?></h3>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="login-user" method="post">
                    
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    
                    <div class="form-group" hidden>
                        <label for="">remember</label>
                        <input type="text" name="remember" class="form-control" value="1">
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-success">Log me</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
