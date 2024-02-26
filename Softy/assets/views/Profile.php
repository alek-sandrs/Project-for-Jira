<div class="div-container">
<?php
if (isset($_SESSION['message'])) {
    echo '
        <div class = "msg-cover">
            <p class="msg"> ' . $_SESSION['message'] .'</p>
        </div>';
}
unset($_SESSION['message']);
?>

<?= $user['username'] ?> <br>
<?= $user['email'] ?><br>
<?= $user['isAdmin'] ?>
</div>
