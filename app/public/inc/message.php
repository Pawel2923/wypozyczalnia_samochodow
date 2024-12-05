<?php
if (isset($_SESSION['msg']) || isset($_SESSION['error'])) {
?>
    <div class="message-wrapper">
        <div class="overlay"></div>
        <div class="message">
            <div class="close"><i class="fas fa-times"></i></div>
            <?php
            if (isset($_SESSION['msg'])) {
            ?>
                <div class="msg">
                    <?php
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                    ?>
                </div>
            <?php
            }
            if (isset($_SESSION['error'])) {
            ?>
                <div class="error">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script src="../js/message.js"></script>
<?php
}
