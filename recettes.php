<?php include_once('includes/init.php'); ?>

<?php
if (
    isset($_GET['search'])
    && !empty($_GET['search'])
) {
    $search = htmlspecialchars($_GET['search']);
}

try {
    if (!isset($search)) {
        $sqlQuery = 'SELECT * FROM RecettesLikes WHERE visible = 1 ORDER BY aime DESC';
        $sqlStatement = $mysqlClient->prepare($sqlQuery);
        $sqlStatement->execute();
    } else {
        $sqlQuery = 'SELECT * FROM RecettesLikes WHERE visible = 1 AND nom LIKE :search ORDER BY aime DESC';
        $sqlStatement = $mysqlClient->prepare($sqlQuery);
        $sqlStatement->execute([
            'search' => '%' . $search . '%'
        ]);
    }
    $recettes = $sqlStatement->fetchAll();
} catch (Exception $e) {
    $_SESSION['ERROR_MSG'] = 'Erreur lors de l\'éxécution de la requête SQL:</br>' . $e->getMessage();
    include_once('includes/error.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once('includes/head.php'); ?>
    <title>Recettes</title>
    <link rel="stylesheet" href="css/recettes.css" />
</head>

<body>
    <div class="main_div">
        <?php $header_searchbar_focus = true; ?>
        <header><?php include_once('includes/header.php'); ?></header>

        <div id="recettes_main">

            <?php if (count($recettes) == 0) : ?>
                <h1>Aucun résultat pour "<?php echo $search; ?>"</h1>
            <?php else : ?>
                <?php if (!isset($search)) : ?>
                    <h1>Liste des recettes</h1>
                <?php else : ?>
                    <h1>Résultats de la recherche "<?php echo $search; ?>"</h1>
                <?php endif; ?>

                <?php if (isset($_SESSION['USER_LOGGED'])) : ?>
                    <div id="recettes_create">
                        <p><a href="recette_create.php" />Créer une recette</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($recettes as $recette) : ?>
                    <a href=<?php echo ('recette.php?id=' . htmlspecialchars($recette['id'])); ?>>
                        <div class="recettes_container">
                            <div class="recettes_nom">
                                <p><?php echo htmlspecialchars($recette['nom']); ?></p>
                            </div>

                            <div class="recettes_desc">
                                <p><?php echo htmlspecialchars($recette['description']); ?></p>
                            </div>

                            <div class="recettes_note_auteur">
                                <p><?php echo ($recette['aime'] . ' Like'); ?></p>

                                <?php if (isset($recette['idAuteur'])) : ?>
                                    <?php
                                    // On récupère l'auteur de la recette
                                    try {
                                        $sqlQuery = 'SELECT * FROM Utilisateurs WHERE id = :id';
                                        $sqlStatement = $mysqlClient->prepare($sqlQuery);
                                        $sqlStatement->execute([
                                            'id' => $recette['idAuteur']
                                        ]);
                                        $utilisateurs = $sqlStatement->fetchAll();
                                    } catch (Exception $e) {
                                        $_SESSION['ERROR_MSG'] = 'Erreur lors de l\'éxécution de la requête SQL:</br>' . $e->getMessage();
                                        include_once('includes/error.php');
                                    }

                                    foreach ($utilisateurs as $utilisateur) {
                                    }
                                    ?>
                                    <strong><?php echo ($utilisateur['pseudo']); ?></strong>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                    <div class="recettes_separator">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer><?php include_once('includes/footer.php'); ?></footer>
</body>

</html>