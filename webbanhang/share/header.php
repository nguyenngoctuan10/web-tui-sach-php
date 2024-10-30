
<div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.php" class="navbar-brand"><h1 class="text-primary display-6">HandBag</h1></a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="shop.php" class="nav-item nav-link">Shop</a>
                    <a href="product-detail.php" class="nav-item nav-link">Product Detail</a>
                     <a href="cart.php" class="nav-item nav-link">Cart</a>
                    <div class="nav-item dropdown">
                        <?php
              echo '<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">' . $fullname . '</a>';
echo '<div class="dropdown-menu m-0 bg-secondary rounded-0">';

if (!$isLoggedIn) {
    echo '<a href="login.php" class="dropdown-item">Đăng Nhập</a>';
    echo '<a href="register.php" class="dropdown-item">Đăng Kí</a>';
} else {
    echo '<a href="logout.php" class="dropdown-item">Đăng Xuất</a>';
}

echo '</div>';
?>
                    </div>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
                <div class="d-flex m-3 me-0">
                    <?php  
                   if ($isLoggedIn) {
    echo '<a href="cart.php" class="position-relative me-4 my-auto">';
    echo '    <i class="fa fa-shopping-bag fa-2x"></i>';
    echo '    <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"></span>';
    echo '</a>';
}
?>
                    <a href="login.php" class="my-auto">
                        <i class="fas fa-user fa-2x"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
   