<?php 
    require_once("getUserProfile.php");
?>

<nav class="mobile-nav">
    <a href="index.php">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="rezerwacja.php">
        <i class="fa-solid fa-bookmark"></i>
        <span>Rezerwacja</span>
    </a>
    <a href="pricing.php">
        <i class="fa-solid fa-tag"></i>
        <span>Wycena</span>
    </a>
    <a href="contact.php">
        <i class="fa-solid fa-comments"></i>
        <span>Kontakt</span>
    </a>
    <a href="#" referrerpolicy="no-referer" class="open">
        <i class="fa-solid fa-circle-user"></i>
        <span>Profil</span>
    </a>
    <div class="mobile-nav-wrapper wrapper-transform">
        <div class="top-content">
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
                </div>
            </div>
        </div>
        <div class="logged-menu show-logged-menu">
            <?php 
                $admin = '';
                if (isset($_SESSION['isAdmin'])) {
                    if ($_SESSION['isAdmin'])
                        $admin = '<li><a href="admin.php"><i class="fa-solid fa-hammer"></i> Panel administracyjny</a></li>';
                }

                if (isset($_SESSION['login']) && !isset($_SESSION['connectionError'])) {
                    echo '
                    <ul>
                        <li>
                            <div class="card">
                                <script>
                                    const date = new Date();
                                    const hour = date.getHours();
                                    let welcomeMessage = "Dzień dobry ";
                                    
                                    if (hour > 19 || hour < 5) {
                                        welcomeMessage = "Dobry wieczór ";
                                    }
                                    
                                    welcomeMessage = welcomeMessage + "<b>'.$userProfile->name.'</b>";
                                    document.write(welcomeMessage);
                                </script>
                                <div>
                                    <div class="number-wrapper">
                                        <div class="card-number">'.$userProfile->unread.'</div>
                                        <span>Nieprzeczytane wiadomości</span>
                                    </div>
                                    <div class="number-wrapper" id="vehicles-button">
                                        <div class="card-number">'.$userProfile->rented_vehicles.'</div>
                                        <span>Wypożyczone pojazdy</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        '.$admin.'
                        <li><a href="user.php"><i class="fa-solid fa-gear"></i> Ustawienia</a></li>
                        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj się</a></li>
                    </ul>
                ';} else {
                    if (!isset($_SESSION['connectionError'])) {
                        echo 'Aby przeglądać swój profil zaloguj się';
                    } else {
                        echo 'Nie można wczytać profilu. Prosimy spróbować później';
                    }
                }
            ?>
        </div>
    </div>
</nav>
<nav class="desktop-nav">
    <div class="nav-header">
        <a href="index.php">
            <h2>Wypożyczalnia</h2>
        </a>
    </div>
    <div class="list-wrapper">
        <div class="spacer"></div>
        <ul>
            <a href="index.php">
                <li>Strona główna</li>
            </a>
            <a href="rezerwacja.php">
                <li>Rezerwacja online</li>
            </a>
            <a href="pricing.php">
                <li>Uzyskaj wycenę</li>
            </a>
            <a href="contact.php">
                <li>Kontakt</li>
            </a>
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
                                echo '<li><a href="admin.php"><i class="fa-solid fa-hammer"></i> Panel administracyjny</a></li>';
                        }
                        ?>
                        <li><a href="user.php"><i class="fa-solid fa-gear"></i> Ustawienia</a></li>
                        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj się</a></li>
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
            <a href="index.php">
                <li>Strona główna</li>
            </a>
            <a href="rezerwacja.php">
                <li>Rezerwacja online</li>
            </a>
            <a href="pricing.php">
                <li>Uzyskaj wycenę</li>
            </a>
            <a href="contact.php">
                <li>Kontakt</li>
            </a>
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
                                echo '<li><a href="admin.php"><i class="fa-solid fa-hammer"></i> Panel administracyjny</a></li>';
                        }
                        ?>
                        <li><a href="user.php"><i class="fa-solid fa-gear"></i> Ustawienia</a></li>
                        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj się</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<script>
    window.addEventListener('scroll', () => {
        const fixedNav = document.querySelector('.fixed-nav');
        if (window.innerWidth > 800) {
            const nav = document.querySelectorAll('.desktop-nav');
            const navHeight = nav[0].offsetHeight;
            if (window.pageYOffset > navHeight) {
                fixedNav.classList.add("fixed-nav-transform");
                fixedNav.style.opacity = 1;
            } else {
                fixedNav.classList.remove("fixed-nav-transform");
            }
        } else {
            fixedNav.classList.remove("fixed-nav-transform");
        }
    });

    const vehiclesBtn = document.getElementById("vehicles-button");

    if (vehiclesBtn) {
        vehiclesBtn.addEventListener('click', () => {
            window.location = "user.php#vehicles";
        });
    }
</script>