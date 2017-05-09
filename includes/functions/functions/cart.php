<?php

/**
 * Verifie si le panier existe, le créé sinon
 * @return booleen
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['idProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
      $_SESSION['panier']['prixProduit'] = array();
      $_SESSION['panier']['titleProduit'] = array();
      $_SESSION['panier']['verrou'] = false;
   }
   return true;
}

function getCart(){
   if (creationPanier() && !isVerrouille())
   {
      return $_SESSION['panier'];
   }
   else 
    return false;
}
/**
 * Ajoute un article dans le panier
 * @param string $idProduit
 * @param int $qteProduit
 * @param float $prixProduit
 * @return void
 */


function ajouterArticle($idProduit,$qteProduit,$prixProduit,$titleProduit){
   $prixProduit = number_format($prixProduit, 2, '.', '');
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($idProduit,  $_SESSION['panier']['idProduit']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['idProduit'],$idProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
         array_push( $_SESSION['panier']['titleProduit'],$titleProduit);

      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}



/**
 * Modifie la quantité d'un article
 * @param $idProduit
 * @param $qteProduit
 * @return void
 */
function modifierQTeArticle($idProduit,$qteProduit){
   //Si le panier éxiste
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($idProduit,  $_SESSION['panier']['idProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
         }
      }
      else
      supprimerArticle($idProduit);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/**
 * Supprime un article du panier
 * @param $idProduit
 * @return unknown_type
 */
function supprimerArticle($idProduit){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['idProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['prixProduit'] = array();
      $tmp['titleProduit'] = array();
      $tmp['verrou'] = $_SESSION['panier']['verrou'];

      for($i = 0; $i < count($_SESSION['panier']['idProduit']); $i++)
      {
         if ($_SESSION['panier']['idProduit'][$i] !== $idProduit)
         {
            array_push( $tmp['idProduit'],$_SESSION['panier']['idProduit'][$i]);
            array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
            array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
            array_push( $tmp['titleProduit'],$_SESSION['panier']['titleProduit'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";

}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['idProduit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
   }
   $total = number_format($total, 2, '.', '');
   return $total;
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier(){
   unset($_SESSION['panier']);
}

/**
 * Permet de savoir si le panier est verrouillé
 * @return booleen
 */
function isVerrouille(){
   if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
   return true;
   else
   return false;
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['idProduit']);
   else
   return 0;

}

function confirmOrder($payment_methode,$status,$adress_fact,$adress_liv){
 if (isset($_SESSION['panier']['idProduit']) && !empty($_SESSION['panier']['idProduit']) && isset($_SESSION['user'])){
   $product = new \App\Product();
   $res = $product->confirmOrder($_SESSION['panier'],$_SESSION['user'],$payment_methode,$status,MontantGlobal(),$adress_fact,$adress_liv); 
   return $res;
 }
 else 
   return false;
}

function updatecart($idProduit,$qte,$id_dec=null){
    $isNewDec = false;

   if (creationPanier())
   {
      $positionProduit = array_search($idProduit,  $_SESSION['panier']['idProduit']);
      /*if ($positionProduit !== false && $id_dec != null) {
          $positionDec = array_search($id_dec,  $_SESSION['panier']['id_dec']);
          if ($positionDec !== false) {
            $positionProduit = $positionDec;
          }else{
            $isNewDec = true;
          }
      }*/

      if ($positionProduit !== false)
      {

         if (is_numeric($qte)){
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qte;
         }
         if ($_SESSION['panier']['qteProduit'][$positionProduit] <= 0) {
           supprimerArticle($idProduit);
         }
      }
    return true;
   }
   else
      return false;
}

?>