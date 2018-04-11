<?php
class Visiteur extends CI_Controller {


  public function __construct()
     {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('assets'); // helper 'assets' ajouté a Application
        $this->load->library("pagination");
        $this->load->model('modelearticle'); // chargement modèle, obligatoire
     } // __construct

  public function afficheracceuil()
  {
    $DonneesInjectees['lesArticles'] = $this->ModeleArticle->retournerArticles();
    $DonneesInjectees['TitreDeLaPage'] = 'Tous les articles';

    $this->load->view('templates/Entete');
    $this->load->view('visiteur/acceuil', $DonneesInjectees);
    $this->load->view('templates/PiedDePage');

  }


}
