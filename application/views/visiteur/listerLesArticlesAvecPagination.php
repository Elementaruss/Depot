<h2><?php echo $TitreDeLaPage ?></h2>
<!-- données récupérées en 'mode objet' -->


<div class="container">
<div class="row">



<?php foreach ($lesArticles as $unArticle):
echo '<div class="col-sm-4">';
    echo '<div class="panel panel-primary";>';
      echo '<div class="panel-heading"> <h3 class="titrearticle">'.anchor('visiteur/voirUnArticle/'.$unArticle->NOPRODUIT,$unArticle->LIBELLE).'</h3></div>';
      echo '<a href="'.site_url('visiteur/voirUnArticle/'.$unArticle->NOPRODUIT).'">';
      echo '<div class="panel-body"><img src="'.site_url('../assets/images/'.$unArticle->NOMIMAGE).'" class="img-responsive" style="width:80%; height: 300px; display: block; margin-left: auto; margin-right: auto" alt="Image"></div>';
      echo '</a>';
      echo '<div class="panel-footer"><span class="pardefaut">'.$unArticle->DETAIL.'</span></div>';
    echo '</div>';
echo '</div>';
endforeach ?>

</div>
</div>

<p><span class="pardefaut">Pour avoir afficher le détail d'un article, cliquer sur son titre</span></p>

<p><?php echo $liensPagination; ?></p>
