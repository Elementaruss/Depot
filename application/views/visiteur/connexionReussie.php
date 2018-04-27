<h2>Connexion réussie !</h2>
<?php echo '<p>Bienvenue '.$Identifiant.' !</p>';?>

<p><a href="<?php echo site_url('administrateur/ajouterunarticle') ?>">Retour à la liste des articles</a><p>
<p><a href="<?php echo site_url('visiteur/afficheracceuil') ?>">Retour à la liste des articles</a><p>
<!-- ou echo anchor('visiteur/listerTousLesArticles','Retour à la liste des articles'); -->
