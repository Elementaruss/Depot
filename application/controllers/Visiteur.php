<?php
class Visiteur extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->helper('url');
      $this->load->helper('assets'); // helper 'assets' ajouté a Application
      $this->load->library("pagination");
      $this->load->model('ModeleArticle'); // chargement modèle, obligatoire
      $this->load->model('ModeleUtilisateur');
      $this->load->helper('form');
      $this->load->library('form_validation');

   } // __construct

   public function afficheracceuil()
   {
    $DonneesInjectees['lesArticles'] = $this->ModeleArticle->retournerArticles();
    $DonneesInjectees['TitreDeLaPage'] = 'Tous les articles';
    $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
    $DonneesEnvoyees["pageActuelle"] = 'afficheracceuil';

    $this->form_validation->set_rules('recherche', 'Identifiant', 'required');

    if ($this->form_validation->run() === FALSE)
   {  // échec de la validation
     // cas pour le premier appel de la méthode : formulaire non encore appelé
     $this->load->view('templates/Entete', $DonneesEnvoyees);
     $this->load->view('visiteur/acceuil', $DonneesInjectees);
     $this->load->view('templates/PiedDePage');
   }
   else
   {  // formulaire validé
    $Recherche = array( // NOCLIENT, MOTDEPASSE : champs de la table tabutilisateur
      'LIBELLE' => $this->input->post('recherche')
    ); // on récupère les données du formulaire de connexion
      redirect('visiteur/unerecherche/'.$Recherche['LIBELLE'].'');
    }

    }

   public function listerLesArticles() // lister tous les articles
   {
    
      $DonneesInjectees['lesArticles'] = $this->ModeleArticle->retournerArticles();
      $DonneesInjectees['TitreDeLaPage'] = 'Tous les articles';
      $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
      $DonneesEnvoyees["pageActuelle"] = 'listerLesArticles';

      $this->form_validation->set_rules('recherche', 'Identifiant', 'required');

      if ($this->form_validation->run() === FALSE)
     {  // échec de la validation
       // cas pour le premier appel de la méthode : formulaire non encore appelé
       $this->load->view('templates/Entete', $DonneesEnvoyees);
       $this->load->view('visiteur/acceuil', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
     else
     {  // formulaire validé
      $Recherche = array( // NOCLIENT, MOTDEPASSE : champs de la table tabutilisateur
        'LIBELLE' => $this->input->post('recherche')
      ); // on récupère les données du formulaire de connexion
      redirect('visiteur/unerecherche/'.$Recherche['LIBELLE'].'');
        //var_dump($Recherche);
      }

   } // listerLesArticles
   public function voirUnArticle($noArticle = NULL) // valeur par défaut de noArticle = NULL
   {
     $DonneesInjectees['unArticle'] = $this->ModeleArticle->retournerArticles($noArticle);
     $DonneesEnvoyees["pageActuelle"] = 'voirUnArticle';
     if (empty($DonneesInjectees['unArticle']))
     {  // pas d'article correspondant au n°
       show_404();
     }

      $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unArticle']['LIBELLE'];
      // ci-dessus, entrée ['cTitre'] de l'entrée ['unArticle'] de $DonneesInjectees
      $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
      
      $this->form_validation->set_rules('recherche', 'Identifiant', 'required');

      if ($this->form_validation->run() === FALSE)
     {  // échec de la validation
       // cas pour le premier appel de la méthode : formulaire non encore appelé
        $this->load->view('templates/Entete', $DonneesEnvoyees);
        $this->load->view('visiteur/VoirUnArticle', $DonneesInjectees);
        $this->load->view('templates/PiedDePage');
     }
     else
     {  // formulaire validé
      $Recherche = array( // NOCLIENT, MOTDEPASSE : champs de la table tabutilisateur
        'LIBELLE' => $this->input->post('recherche')
      ); // on récupère les données du formulaire de connexion
      redirect('visiteur/unerecherche/'.$Recherche['LIBELLE'].'');
        //var_dump($Recherche);
      }

    } // voirUnArticle

    public function unerecherche($leLibelle = NULL)
    {
      //var_dump($leLibelle);
      // les noms des entrées dans $config doivent être respectés
  $config = array();
  $config["base_url"] = site_url('visiteur/listerLesArticlesAvecPagination');
  $config["total_rows"] = $this->ModeleArticle->nombreDArticlesParRecherche($leLibelle);
  $config["per_page"] = 6; // nombre d'articles par page
  $config["uri_segment"] = 3; /* le n° de la page sera placé sur le segment n°3 de URI,
  pour la page 4 on aura : visiteur/listerLesArticlesAvecPagination/4   */

  $config['first_link'] = 'Premier';
  $config['last_link'] = 'Dernier';
  $config['next_link'] = 'Suivant';
  $config['prev_link'] = 'Précédent';

  $this->pagination->initialize($config);

  $noPage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  /* on récupère le n° de la page - segment 3 - si ce segment est vide, cas du premier appel
  de la méthode, on affecte 0 à $noPage */

  $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
  $DonneesEnvoyees["pageActuelle"] = 'unerecherche';

  $DonneesInjectees['TitreDeLaPage'] = 'Recherche : '.$leLibelle.'';
  $DonneesInjectees["lesArticles"] = $this->ModeleArticle->retournerArticlesParRecherche($config["per_page"], $noPage, $leLibelle);
  $DonneesInjectees["liensPagination"] = $this->pagination->create_links();

  $this->form_validation->set_rules('recherche', 'Identifiant', 'required');

      if ($this->form_validation->run() === FALSE)
     {  // échec de la validation
       // cas pour le premier appel de la méthode : formulaire non encore appelé
       $this->load->view('templates/Entete', $DonneesEnvoyees);
       $this->load->view("visiteur/listerLesArticlesAvecPagination", $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
     else
     {  // formulaire validé
      $this->load->view('templates/Entete', $DonneesEnvoyees);
       $this->load->view("visiteur/listerLesArticlesAvecPagination", $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
        //var_dump($Recherche);
      }
  }

    public function seConnecter()

{
   $DonneesInjectees['TitreDeLaPage'] = 'Se connecter';
   $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
   $DonneesEnvoyees["pageActuelle"] = 'seConnecter';

   $this->form_validation->set_rules('txtIdentifiant', 'Identifiant', 'required');
   $this->form_validation->set_rules('txtMotDePasse', 'Mot de passe', 'required');
   // Les champs txtIdentifiant et txtMotDePasse sont requis
   // Si txtMotDePasse non renseigné envoi de la chaine 'Mot de passe' requis

   if ($this->form_validation->run() === FALSE)
   {  // échec de la validation
     // cas pour le premier appel de la méthode : formulaire non encore appelé
     $this->load->view('templates/Entete', $DonneesEnvoyees);
     $this->load->view('visiteur/seConnecter', $DonneesInjectees); // on renvoie le formulaire
     $this->load->view('templates/PiedDePage');
   }
   else
   {  // formulaire validé
     $Utilisateur = array( // NOCLIENT, MOTDEPASSE : champs de la table tabutilisateur
       'PRENOM' => $this->input->post('txtIdentifiant'),
       'MOTDEPASSE' => $this->input->post('txtMotDePasse'),
     ); // on récupère les données du formulaire de connexion

     // on va chercher l'utilisateur correspondant aux Id et MdPasse saisis
     $UtilisateurRetourne = $this->ModeleUtilisateur->retournerUtilisateur($Utilisateur);
     if (!($UtilisateurRetourne == null))
     {    // on a trouvé, identifiant et statut (droit) sont stockés en session
       $this->load->library('session');
       $this->session->identifiant = $UtilisateurRetourne->PRENOM;
       $this->session->statut = $UtilisateurRetourne->PROFIL;

       $DonneesInjectees['Identifiant'] = $Utilisateur['PRENOM'];
       $this->load->view('templates/Entete', $DonneesEnvoyees);
       $this->load->view('visiteur/connexionReussie', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
     else
     {    // utilisateur non trouvé on renvoie le formulaire de connexion
       $this->load->view('templates/Entete', $DonneesEnvoyees);
       $this->load->view('visiteur/seConnecter', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
   }
 } // fin seConnecter

 public function seDeConnecter() { // destruction de la session = déconnexion
    $this->session->sess_destroy();
    $this->load->helper('url');
    
    redirect('visiteur/afficheracceuil');
    

}

// affichage avec pagination
public function listerLesArticlesAvecPagination() {
  // les noms des entrées dans $config doivent être respectés
  $config = array();
  $config["base_url"] = site_url('visiteur/listerLesArticlesAvecPagination');
  $config["total_rows"] = $this->ModeleArticle->nombreDArticles();
  $config["per_page"] = 6; // nombre d'articles par page
  $config["uri_segment"] = 3; /* le n° de la page sera placé sur le segment n°3 de URI,
  pour la page 4 on aura : visiteur/listerLesArticlesAvecPagination/4   */

  $config['first_link'] = 'Premier';
  $config['last_link'] = 'Dernier';
  $config['next_link'] = 'Suivant';
  $config['prev_link'] = 'Précédent';

  $this->pagination->initialize($config);

  $noPage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  /* on récupère le n° de la page - segment 3 - si ce segment est vide, cas du premier appel
  de la méthode, on affecte 0 à $noPage */

  $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
  $DonneesEnvoyees["pageActuelle"] = 'listerLesArticlesAvecPagination';

  $DonneesInjectees['TitreDeLaPage'] = 'Les articles, avec pagination';
  $DonneesInjectees["lesArticles"] = $this->ModeleArticle->retournerArticlesLimite($config["per_page"], $noPage);
  $DonneesInjectees["liensPagination"] = $this->pagination->create_links();

  $this->form_validation->set_rules('recherche', 'Identifiant', 'required');

      if ($this->form_validation->run() === FALSE)
     {  // échec de la validation
       // cas pour le premier appel de la méthode : formulaire non encore appelé
       $this->load->view('templates/Entete', $DonneesEnvoyees);
       $this->load->view("visiteur/listerLesArticlesAvecPagination", $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
     else
     {  // formulaire validé
      $Recherche = array( // NOCLIENT, MOTDEPASSE : champs de la table tabutilisateur
        'LIBELLE' => $this->input->post('recherche')
      ); // on récupère les données du formulaire de connexion
      redirect('visiteur/unerecherche/'.$Recherche['LIBELLE'].'');
        //var_dump($Recherche);
      }

} // fin listerLesArticlesAvecPagination


public function listerLesArticlesParCategorie($noCategorie = NULL) {
  // les noms des entrées dans $config doivent être respectés
  $config = array();
  $config["base_url"] = site_url('visiteur/listerLesArticlesParCategorie');
  $config["total_rows"] = $this->ModeleArticle->nombreDArticlesParCategorie($noCategorie);
  $config["per_page"] = 6; // nombre d'articles par page
  $config["uri_segment"] = 3; /* le n° de la page sera placé sur le segment n°3 de URI,
  pour la page 4 on aura : visiteur/listerLesArticlesAvecPagination/4   */

  $config['first_link'] = 'Premier';
  $config['last_link'] = 'Dernier';
  $config['next_link'] = 'Suivant';
  $config['prev_link'] = 'Précédent';

  $this->pagination->initialize($config);

  $noPage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  /* on récupère le n° de la page - segment 3 - si ce segment est vide, cas du premier appel
  de la méthode, on affecte 0 à $noPage */

  $DonneesEnvoyees["lesCategories"] = $this->ModeleArticle->retournerCategories();
  $DonneesEnvoyees["pageActuelle"] = 'listerLesArticlesParCategorie';

  $DonneesInjectees['TitreDeLaPage'] = $this->ModeleArticle->retournerCategories($noCategorie);
  $DonneesInjectees["lesArticles"] = $this->ModeleArticle->retournerArticlesParCategorie($config["per_page"], $noPage, $noCategorie);
  $DonneesInjectees["liensPagination"] = $this->pagination->create_links();

  $this->form_validation->set_rules('recherche', 'Identifiant', 'required');

      if ($this->form_validation->run() === FALSE)
     {  // échec de la validation
       // cas pour le premier appel de la méthode : formulaire non encore appelé
       $this->load->view('templates/Entete', $DonneesEnvoyees);
      var_dump($DonneesInjectees["lesArticles"]);
      $this->load->view("visiteur/listerLesArticlesAvecPagination", $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
     }
     else
     {  // formulaire validé
      $Recherche = array( // NOCLIENT, MOTDEPASSE : champs de la table tabutilisateur
        'LIBELLE' => $this->input->post('recherche')
      ); // on récupère les données du formulaire de connexion
      redirect('visiteur/unerecherche/'.$Recherche['LIBELLE'].'');
        //var_dump($Recherche);
      }

} // fin listerLesArticlesAvecPagination

}  // Visiteur
