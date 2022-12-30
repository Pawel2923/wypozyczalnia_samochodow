<div class="logged-menu">
    <ul>
        <?php
        if (isset($_SESSION['isAdmin'])) {
            if ($_SESSION['isAdmin'])
                echo '<li><a href="admin.php"><i class="fa-solid fa-hammer"></i> Panel administracyjny</a></li>';
        }
        ?>
        <li><a href="user.php"><i class="fa-solid fa-gear"></i> Panel użytkownika</a></li>
        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj się</a></li>
    </ul>
</div>