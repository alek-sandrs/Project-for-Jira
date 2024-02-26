    <div class="form-container">
        <form action="/register" method="POST">
            <h2 class="form-title">Sign Up</h2>
            <?php
                if (isset($_SESSION['error'])) {
                    echo '
                        <div class = "err-cover">
                            <p class="err"> ' . $_SESSION['error'] .'</p>
                        </div>';
                }
                unset($_SESSION['error']);
            ?>
            <div class="form-input">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-input">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-input">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-input">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confrirm Password" required>
            </div>
            <input type="submit" class="form-button" value="Sign Up">
        </form>
    </div>
