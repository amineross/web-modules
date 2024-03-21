<main> 
    <div class="error-container">
        <h1>Oops! Something went wrong.</h1>
        <p><?php echo isset($errorMsg) ? htmlspecialchars($errorMsg) : "An unknown error occurred."; ?></p>
        <a href="index.php">Back to Home</a>
    </div>
</main>

