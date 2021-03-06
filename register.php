<?php include_once('includes/init.php'); ?>

<?php
if (isset($_SESSION['USER_LOGGED'])) {
    include_once('includes/redirect_backward.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once('includes/head.php'); ?>
    <title>Inscription</title>
    <link rel="stylesheet" href="css/auth.css" />
</head>

<body>
    <div class="main_div">
        <header><?php include_once('includes/header.php'); ?></header>

        <div id="auth_main_div">

            <form action="submit_register.php" method="POST" id="auth_form">

                <h1>Inscription</h1>

                <label for="email">Email</label>
                <input type="email" name="email" autofocus required placeholder="Email" />

                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" required placeholder="Pseudo" />

                <label for="nom">Nom</label>
                <input type="text" name="nom" required placeholder="Nom" />

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" required placeholder="Prénom" />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" required placeholder="Mot de passe" />
                <input type="password" name="password_comfirm" required placeholder="Confirmer mot de passe" />

                <div id="auth_button_div">
                    <input type="submit" value="S'inscrire" id="auth_buttom" /></br>
                    <a href="login.php">Déjà inscrit?</a>
                </div>

            </form>

        </div>
    </div>

    <footer><?php include_once('includes/footer.php'); ?></footer>
</body>

</html>