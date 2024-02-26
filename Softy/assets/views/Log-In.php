<div class="form-container">
  <form action="/login" method="post">
  <h2 class="form-title">Login</h2>
  <?php
            if (isset($_SESSION['error'])) {
                echo '
                    <div class = "err-cover">
                        <p class="err"> ' . $_SESSION['error'] .'</p>
                    </div>';
            }
            unset($_SESSION['error']);
            ?>
    <input type="text" name="username" placeholder="Username or E-mail" class="username" required>
    <input type="password" name="password" placeholder="Password" class="password" required>
    <input type="submit" value="Login" class="button">
  </form>
</div>