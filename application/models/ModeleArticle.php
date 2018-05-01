<?php
class ModeleArticle extends CI_Model {

public function __construct()
{
$this->load->database();
/* chargement database.php (dans config), obligatoirement dans le constructeur */
}

     public function retournerArticles($pNoArticle = FALSE)
     {
        if ($pNoArticle === FALSE) // pas de n° d'article en paramètre
        {  // on retourne tous les articles
             $requete = $this->db->get('produit');
             return $requete->result_array(); // retour d'un tableau associatif
        }
        // ici on va chercher l'article dont l'id est $pNoArticle
        $requete = $this->db->get_where('produit', array('NOPRODUIT' => $pNoArticle));
        return $requete->row_array(); // retour d'un tableau associatif
     } // fin retournerArticles

     public function insererUnArticle($pDonneesAInserer)
          {
       return $this->db->insert('produit', $pDonneesAInserer);
     } // insererUnArticle

     public function retournerArticlesParRecherche($nombreDeLignesARetourner, $noPremiereLigneARetourner, $plibelle)
     {// Nota Bene : surcharge non supportée par PHP
       //$this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
       //$requete = $this->db->get('produit');
       //$this->db->like('LIBELLE', $plibelle);
       $this->db->select('*');
       $this->db->from('produit');
       $this->db->like('LIBELLE', $plibelle, 'both');
       $requete = $this->db->get();
      // Produces: WHERE title LIKE '%match%'
       if ($requete->num_rows() > 0) { // si nombre de lignes > 0
         foreach ($requete->result() as $ligne) {
           $jeuDEnregsitrements[] = $ligne;
         }
         return $jeuDEnregsitrements;
       } // fin if
       return false;
     } // retournerArticlesLimite

     public function nombreDArticlesParRecherche($plibelle) { // méthode utilisée pour la pagination
        //$requete = $this->db->get('produit');
        //$this->db->like('LIBELLE', $plibelle);
        $this->db->like('LIBELLE', $plibelle, 'both');
        $this->db->from('produit');
        return $this->db->count_all_results();
        //return $requete->num_rows();
    } // nombreDArticlesParCategorie

     public function retournerArticlesLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner)
     {// Nota Bene : surcharge non supportée par PHP
       $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
       $requete = $this->db->get("produit");

       if ($requete->num_rows() > 0) { // si nombre de lignes > 0
         foreach ($requete->result() as $ligne) {
           $jeuDEnregsitrements[] = $ligne;
         }
         return $jeuDEnregsitrements;
       } // fin if
       return false;
     } // retournerArticlesLimite

     public function retournerArticlesParCategorie($nombreDeLignesARetourner, $noPremiereLigneARetourner, $pNoCategorie)
     {// Nota Bene : surcharge non supportée par PHP
       $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
       $requete = $this->db->get_where('produit', array('NOCATEGORIE' => $pNoCategorie));
        var_dump($requete->result());
       if ($requete->num_rows() > 0) { // si nombre de lignes > 0
         foreach ($requete->result() as $ligne) {
           $jeuDEnregsitrements[] = $ligne;
         }
         return $jeuDEnregsitrements;
       } // fin if
       return false;
     } // retournerArticlesLimite

     public function nombreDArticles() { // méthode utilisée pour la pagination
       return $this->db->count_all("PRODUIT");
     } // nombreDArticles

     public function nombreDArticlesParCategorie($pNoCategorie) { // méthode utilisée pour la pagination
      $requete = $this->db->get_where('produit', array('NOCATEGORIE' => $pNoCategorie));
      return $requete->num_rows();
    } // nombreDArticlesParCategorie

     public function retournerCategories($pNoCategorie = FALSE)
     {
        if ($pNoCategorie === FALSE) // pas de n° d'article en paramètre
        {  // on retourne tous les articles
             $requete = $this->db->get('categorie');
             return $requete->result_array(); // retour d'un tableau associatif
        }
        // ici on va chercher l'article dont l'id est $pNoArticle
        $requete = $this->db->get_where('categorie', array('NOCATEGORIE' => $pNoCategorie));
        return $requete->row_array(); // retour d'un tableau associatif
     } // fin retournerArticles

     public function retournerNoCategorie($pLabelle)
{
   $requete = $this->db->get_where('categorie',array('LIBELLE' => $pLabelle));
   return $requete->row("NOCATEGORIE"); // retour d'une seule ligne !
   // retour sous forme d'objets
} // retournerUtilisateur

} // Fin Classe
