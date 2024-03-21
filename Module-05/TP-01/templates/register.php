<main>
    <section class="container">
        <h1 class="RegisterH1">Register</h1>
            <form action="index.php?action=register" method="post">
                <?php if (isset($_SESSION['csrf_token'])) : ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <?php else : ?>
                    <?php functions\generateCsrfToken(); ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <?php endif; ?>
                <label for="nom">Family name:</label>
                <input type="text" id="nom" name="nom" required>
                <?php if (isset($data['errors']['nom'])) : ?>
                    <p class="error-message"><?php echo $data['errors']['nom']; ?></p>
                <?php endif; ?>
                <label for="prenom">First name:</label>
                <input type="text" id="prenom" name="prenom" required>
                <?php if (isset($data['errors']['prenom'])) : ?>
                    <p class="error-message"><?php echo $data['errors']['prenom']; ?></p>
                <?php endif; ?>
                <label for="adresse">Address:</label>
                <input type="text" id="adresse" name="adresse" required>
                <?php if (isset($data['errors']['adresse'])) : ?>
                    <p class="error-message"><?php echo $data['errors']['adresse']; ?></p>
                <?php endif; ?>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <?php if (isset($data['errors']['email'])) : ?>
                    <p class="error-message"><?php echo $data['errors']['email']; ?></p>
                <?php endif; ?>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($data['errors']['password'])) : ?>
                    <p class="error-message"><?php echo $data['errors']['password']; ?></p>
                <?php endif; ?>
                <label for="confirm_password">Confirm password: </label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <?php if (isset($data['errors']['confirm_password'])) : ?>
                    <p class="error-message"><?php echo $data['errors']['confirm_password']; ?></p>
                <?php endif; ?>
                <?php
                // Afficher les messages d'erreur s'il y en a
                if (isset($error) && $error === 'email_exists') {
                    echo "<p class='error-message'>Email already in use.</p>";
                } elseif (isset($error) && $error === 'password_mismatch') {
                    echo "<p class='error-message'>Passwords don't match</p>";
                }
                ?>
                <button type="submit">Register</button>
            </form>
    </section>
</main>