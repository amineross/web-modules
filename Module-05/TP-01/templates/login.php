<!-- login.php -->
<main>
    <section class="container">
        <h1>Connexion</h1>
        <form action="index.php?action=login" method="post">
            <?php if (isset($_SESSION['csrf_token'])) : ?>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <?php else : ?>
                <?php functions\generateCsrfToken(); ?>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <?php endif; ?>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <?php
                if (isset($error) && $error === 'wrong_email_password') {
                    echo "<p class='error-message'>Incorrect email or password</p>";
                }
            ?>
            <button type="submit">Log in</button>
        </form>
    </section>
</main>
