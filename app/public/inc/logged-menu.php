<div class="logged-menu">
    <ul>
        <?php
        if (isset($_SESSION['isAdmin'])) {
            if ($_SESSION['isAdmin'])
        ?><li><a class="logged-menu-admin" href="admin.php"><i class="fa-solid fa-hammer"></i> Panel administracyjny</a></li><?php
        }?>
        <li><a class="logged-menu-user" href="user.php"><i class="fa-solid fa-user-gear"></i> Panel użytkownika</a></li>
        <li><a class="logged-menu-logout" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj się</a></li>
    </ul>
</div>
<script nonce="loggedMenu">
    if (
        window.location.pathname.includes("/admin/") ||
        window.location.pathname.includes("/user/")
    ) {
        document.querySelectorAll(".logged-menu-admin").forEach((elem) => {
            elem.setAttribute("href", "../admin.php");
        });
        document.querySelectorAll(".logged-menu-user").forEach((elem) => {
            elem.setAttribute("href", "../user.php");
        });
        document.querySelectorAll(".logged-menu-logout").forEach((elem) => {
            elem.setAttribute("href", "../logout.php");
        });
    }
</script>