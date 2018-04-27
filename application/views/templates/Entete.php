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

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo site_url('visiteur/afficheracceuil') ?>">LOGO</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo site_url('visiteur/afficheracceuil') ?>">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
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
