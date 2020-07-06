<?php
if(!isset($login)){
  header('Location: /home');
  exit();
}
?>
<header class="container position-sticky">
<nav class="navbar">
  <div class="navbar-brand">
    <a href="/admin">
    <div class="logo">
      <i class="fa fa-home fa-2x"></i>
    </div>
    </a>
  </div>
  <div class="navbar-text">
    <span>Welcome Bamise</span>
    <a href="/admin/logout" class="btn btn-danger"> <i class="fa fa-user"></i> logout</a>
  </div>
</nav>
</header>