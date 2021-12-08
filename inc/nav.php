<nav class="mobile-nav">
    <div class="open"><i class="fas fa-bars"></i></div>
    <div class="nav-wrapper">
        <div class="top-content">
            <div></div>
            <div class="close"><i class="fas fa-times"></i></div>
            <div class="user">
                <div class="mobile-logged-menu-overlay"></div>
                <a href="login.php" class="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="login-caption">Zaloguj się</span>
                </a>
                <div class="logged">
                    <i class="fas fa-user"></i>
                    <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                    <div class="logged-menu">
                        <ul>
                            <?php
                                if (isset($_SESSION['isAdmin'])) {
                                    if ($_SESSION['isAdmin'])
                                        echo '<li><a href="admin.php">Panel administracyjny</a></li>';
                                }
                            ?>
                            <li><a href="user.php">Panel użytkownika</a></li>
                            <li><a href="logout.php">Wyloguj się</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-wrapper">
            <ul>
                <a href="index.php"><li>Strona główna</li></a>
                <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
                <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
                <a href="vehicles.php"><li>Nasze pojazdy</li></a>
                <a href="contact.php"><li>Kontakt</li></a>
            </ul>
        </div>
    </div>
</nav>
<nav class="desktop-nav">
    <div class="nav-header">
        <a href="index.php"><h2>Wypożyczalnia</h2></a>
    </div>
    <div class="list-wrapper">
        <div class="spacer"></div>
        <ul>
            <a href="index.php"><li>Strona główna</li></a>
            <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
            <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
            <a href="vehicles.php"><li>Nasze pojazdy</li></a>
            <a href="contact.php"><li>Kontakt</li></a>
        </ul>
        <div class="user">
            <a href="login.php" class="login">
                <i class="fas fa-sign-in-alt"></i>
                <span class="login-caption">Zaloguj się</span>
            </a>
            <div class="logged">
                <i class="fas fa-user"></i>
                <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                <div class="logged-menu">
                    <ul>
                        <?php
                            if (isset($_SESSION['isAdmin'])) {
                                if ($_SESSION['isAdmin'])
                                    echo '<li><a href="admin.php">Panel administracyjny</a></li>';
                            }
                        ?>
                        <li><a href="user.php">Panel użytkownika</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<nav class="desktop-nav fixed-nav">
    <div class="list-wrapper">
        <div class="spacer"></div>
        <ul>
            <a href="index.php"><li>Strona główna</li></a>
            <a href="rezerwacja.php"><li>Rezerwacja online</li></a>
            <a href="wycena.php"><li>Uzyskaj wycenę</li></a>
            <a href="vehicles.php"><li>Nasze pojazdy</li></a>
            <a href="contact.php"><li>Kontakt</li></a>
        </ul>
        <div class="user">
            <a href="login.php" class="login">
                <i class="fas fa-sign-in-alt"></i>
                <span class="login-caption">Zaloguj się</span>
            </a>
            <div class="logged">
                <i class="fas fa-user"></i>
                <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                <div class="logged-menu">
                    <ul>
                        <?php
                            if (isset($_SESSION['isAdmin'])) {
                                if ($_SESSION['isAdmin'])
                                    echo '<li><a href="admin.php">Panel administracyjny</a></li>';
                            }
                        ?>
                        <li><a href="user.php">Panel użytkownika</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<script>
    window.addEventListener('scroll', () => {
        if (window.innerWidth > 800) {
            const nav = document.querySelectorAll('.desktop-nav');
            const navHeight = nav[0].offsetHeight;
            if (window.pageYOffset > navHeight) {
                document.querySelector('.fixed-nav').style.transform = "translateY(0)";
                document.querySelector('.fixed-nav').style.webkitTransform = "translateY(0)";
                document.querySelector('.fixed-nav').style.mozTransform = "translateY(0)";
                document.querySelector('.fixed-nav').style.msTransform = "translateY(0)";
                document.querySelector('.fixed-nav').style.oTransform = "translateY(0)";
                document.querySelector('.fixed-nav').style.opacity = 1;
            }
            else {
                document.querySelector('.fixed-nav').style.transform = "translateY(-100%)";
                document.querySelector('.fixed-nav').style.webkitTransform = "translateY(-100%)";
                document.querySelector('.fixed-nav').style.mozTransform = "translateY(-100%)";
                document.querySelector('.fixed-nav').style.msTransform = "translateY(-100%)";
                document.querySelector('.fixed-nav').style.oTransform = "translateY(-100%)";
            }
        }
        else {
            document.querySelector('.fixed-nav').style.transform = "translateY(-100%)";
            document.querySelector('.fixed-nav').style.webkitTransform = "translateY(-100%)";
            document.querySelector('.fixed-nav').style.mozTransform = "translateY(-100%)";
            document.querySelector('.fixed-nav').style.msTransform = "translateY(-100%)";
            document.querySelector('.fixed-nav').style.oTransform = "translateY(-100%)";
        }
    });
</script>