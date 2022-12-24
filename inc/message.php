<div class="message-wrapper" <?php if (isset($_SESSION['msg']) || isset($_SESSION['error'])) echo 'style="display: flex;"' ?>>
    <div class="overlay"></div>
    <div class="message">
        <div class="close"><i class="fas fa-times"></i></div>
        <div class="msg">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>
        <div class="error">
            <?php
            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</div>