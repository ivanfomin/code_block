<?php

$this->layout('layout', ['title' => 'My Blog']) ?>
<section>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">My blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                if ($auth->isLoggedIn()) {
                    d($auth->getRoles());
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout">Logout <span class="sr-only">(current)</span></a>
                    </li>
                <?php } else { ?>


                    <li class="nav-item active">
                        <a class="nav-link" href="register">Register <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="login">Login <span class="sr-only">(current)</span></a>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </nav>
    <p><?php if ($auth->isLoggedIn()) {
            echo 'Hello ' . $auth->getUsername();
        } ?></p>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <?php if ($auth->isLoggedIn()) { ?>
                    <a href="/create" class="btn btn-success">Add post</a> <?php } ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Read</th>
                        <?php if ($auth->isLoggedIn()) { ?>
                            <th scope="col">Actions</th>
                        <?php } ?>

                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($posts as $post) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo ++$i; ?></th>
                            <td>
                                <a href="/read/<?php echo $post['id']; ?>"><?= $this->e($post['title']) ?></a>
                            </td>
                            <?php if ($auth->getUserId() == $post['create_id'] || $auth->hasRole(\Delight\Auth\Role::ADMIN)) { ?>
                                <td>
                                    <a href="/edit/<?php echo $post['id']; ?>" class="btn btn-warning">Edid</a>
                                </td>
                                <td>
                                    <a href="/delete/<?php echo $post['id']; ?>" class="btn btn-danger"
                                       onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            <?php } ?>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
