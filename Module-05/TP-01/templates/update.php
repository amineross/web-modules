<?php
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    
    $userInfo = getUserInfos($_SESSION['user_id']);
?>

<main>
    <section class="container">
        <h1>Edit my info</h1>
        <form action="index.php?action=update" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="nom">Family name:</label>
            <input type="text" id="nom" name="nom" value="<?= functions\sanitizeInput($userInfo['nom']); ?>" required>
            <?php if (isset($data['errors']['nom'])) : ?>
                <p class="error-message"><?php echo $data['errors']['nom']; ?></p>
            <?php endif; ?>
            <label for="prenom">First name:</label>
            <input type="text" id="prenom" name="prenom" value="<?= functions\sanitizeInput($userInfo['prenom']); ?>" required>
            <?php if (isset($data['errors']['prenom'])) : ?>
                <p class="error-message"><?php echo $data['errors']['prenom']; ?></p>
            <?php endif; ?>
            <label for="adresse">Address:</label>
            <input type="text" id="adresse" name="adresse" required value="<?= functions\sanitizeInput($userInfo['adresse']); ?>" required>
            <?php if (isset($data['errors']['adresse'])) : ?>
                <p class="error-message"><?php echo $data['errors']['adresse']; ?></p>
            <?php endif; ?>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= functions\sanitizeInput($userInfo['email']); ?>" required>
            <?php if (isset($data['errors']['email'])) : ?>
                <p class="error-message"><?php echo $data['errors']['email']; ?></p>
            <?php endif; ?>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <?php if (isset($data['errors']['password'])) : ?>
                <p class="error-message"><?php echo $data['errors']['password']; ?></p>
            <?php endif; ?>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <?php if (isset($data['errors']['confirm_password'])) : ?>
                <p class="error-message"><?php echo $data['errors']['confirm_password']; ?></p>
            <?php endif; ?>
            <?php
            if (isset($error) && $error === 'email_exists') {
                echo "<p class='error-message'>Email already in use.</p>";
            } elseif (isset($error) && $error === 'password_mismatch') {
                echo "<p class='error-message'>Passwords don't match</p>";
            }
            ?>
            <button type="submit">Apply</button>
        </form>
    </section>
</main>