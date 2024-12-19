<header>
    <h1>Fur & Friends</h1>
    <nav>
        <a href="<?= $base_path ?>index.php">Home</a>
        <a href="<?= $base_path ?>view/training_tips.php">Training Tips</a>
        <a href="<?= $base_path ?>view/diy_ideas.php">DIY Ideas</a>
        <a href="<?= $base_path ?>view/health_tips.php">Health Tips</a>
        <a href="<?= $base_path ?>view/about.php">About</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="<?= $base_path ?>actions/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?= $base_path ?>view/login.php">Login</a>
            <a href="<?= $base_path ?>view/signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>
