<!DOCTYPE html>
<html lang="en">
<head>
  <title>Skiny</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo site_url('../assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo site_url('../assets/css/bootstrap.css') ?>">
  <script src="<?php echo site_url('../assets/js/jquery.min.js') ?>"></script>
  <script src="<?php echo site_url('../assets/js/bootstrap.min.js') ?>"></script>
</head>
<body>
<?php
echo validation_errors();
echo form_open('visiteur/'.$pageActuelle.'');
//var_dump($pageActuelle)
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo site_url('visiteur/afficheracceuil') ?>">LOGO</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo site_url('visiteur/afficheracceuil') ?>">Acceuil</a></li>
      <li><a href="<?php echo site_url('visiteur/listerLesArticlesAvecPagination') ?>">Tous les produits</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Catégorie<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php
          foreach ($lesCategories as $uneCategorie):
          echo '<li><a href="'.site_url('visiteur/listerLesArticlesParCategorie/'.$uneCategorie['NOCATEGORIE']).'">'.$uneCategorie['LIBELLE'].'</a></li>';
          endforeach
          ?>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
      <form class="navbar-form navbar-right" role="search">
        <div class="form-group input-group">
          <?php
          echo form_input('recherche', set_value('rechercher'));
          echo form_submit('submit', 'Rechercher');
          ?>
        </div>
      </form>
      <li><a href="<?php echo site_url('visiteur/sInscrire') ?>"><span class="glyphicon glyphicon-user"></span> S'inscrire</a></li>
      <li><a href="<?php echo site_url('visiteur/seConnecter') ?>"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  
    
    <?php if (!is_null($this->session->identifiant)) : ?>
       <?php echo 'Utilisateur connecté : <B>'.$this->session->identifiant.'</B>&nbsp;&nbsp;';?>
       <a href="<?php echo site_url('visiteur/seDeconnecter') ?>">Se déconnecter</a>&nbsp;&nbsp;
       <?php if ($this->session->statut=='Administrateur') : ?>
          <a href="<?php echo site_url('administrateur/ajouterUnArticle') ?>">Ajouter un article</a>&nbsp;&nbsp;
       <?php endif; ?>
    <?php else : ?>
       <a href="<?php echo site_url('visiteur/seConnecter') ?>">Se Connecter</a>&nbsp;&nbsp;
    <?php endif; ?>
    <a href="<?php echo site_url('visiteur/afficheracceuil') ?>">Lister tous les Articles</a>&nbsp;&nbsp;
    <a href="<?php echo site_url('visiteur/listerLesArticlesAvecPagination') ?>">Lister les Articles (par 3)</a>&nbsp;&nbsp;
    <?php echo form_close(); ?>
