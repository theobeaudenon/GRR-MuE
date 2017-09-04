<?php
/**
 * admin_config2.php
 * Interface permettant à l'administrateur la configuration de certains paramètres généraux
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2011-01-11 09:37:50 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config2.php,v 1.2 2011-01-11 09:37:50 grr Exp $
 * @filesource
 *
 * This file is part of GRR.
 *
 * GRR is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GRR is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GRR; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * Dernière modification 2014-08-25 : CD - GIP RECIA - pour GRR version 2.0.2
        Meilleur alignement du bouton "save"
 */
/**
 * $Log: admin_config2.php,v $
 * Revision 1.2  2011-01-11 09:37:50  grr
 * *** empty log message ***
 *
 * Revision 1.1  2010-05-07 21:26:44  grr
 * *** empty log message ***
 *
 * Revision 1.11  2009-09-29 18:02:56  grr
 * *** empty log message ***
 *
 * Revision 1.10  2009-04-09 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.9  2009-02-27 13:28:19  grr
 * *** empty log message ***
 *
 * Revision 1.8  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 * Revision 1.7  2008-11-10 08:17:34  grr
 * *** empty log message ***
 *
 * Revision 1.6  2008-11-10 07:06:39  grr
 * *** empty log message ***
 *
 *
 */

// Nombre maximum de réservation (tous domaines confondus)
if (isset($_GET['UserAllRoomsMaxBooking'])) {
    settype($_GET['UserAllRoomsMaxBooking'],"integer");
    if ($_GET['UserAllRoomsMaxBooking']=='') $_GET['UserAllRoomsMaxBooking'] = -1;
    if ($_GET['UserAllRoomsMaxBooking']<-1) $_GET['UserAllRoomsMaxBooking'] = -1;
    if (!Settings::setEtab("UserAllRoomsMaxBooking", $_GET['UserAllRoomsMaxBooking'])) {
        echo "Erreur lors de l'enregistrement de UserAllRoomsMaxBooking !<br />";
        die();
    }
}

// Visualisation de la fiche de description d'une ressource.
if (isset($_GET['visu_fiche_description'])) {
    if (!Settings::setEtab("visu_fiche_description", $_GET['visu_fiche_description'])) {
        echo "Erreur lors de l'enregistrement de visu_fiche_description !<br />";
        die();
    }
}

// Accès fiche de réservation d'une ressource.
if (isset($_GET['acces_fiche_reservation'])) {
    if (!Settings::setEtab("acces_fiche_reservation", $_GET['acces_fiche_reservation'])) {
        echo "Erreur lors de l'enregistrement de acces_fiche_reservation !<br />";
        die();
    }
}

// allow_user_delete_after_begin
if (isset($_GET['allow_user_delete_after_begin'])) {
    if (!Settings::setEtab("allow_user_delete_after_begin", $_GET['allow_user_delete_after_begin'])) {
        echo "Erreur lors de l'enregistrement de allow_user_delete_after_begin !<br />";
        die();
    }
}
// allow_gestionnaire_modify_del
if (isset($_GET['allow_gestionnaire_modify_del'])) {
    if (!Settings::setEtab("allow_gestionnaire_modify_del", $_GET['allow_gestionnaire_modify_del'])) {
        echo "Erreur lors de l'enregistrement de allow_gestionnaire_modify_del !<br />";
        die();
    }
}

if (!Settings::load())
    die("Erreur chargement settings");

# print the page header
//print_header("","","","",$type="with_session", $page="admin");
print_header('', '', '', $type = 'with_session');
if (isset($_GET['ok'])) {
    $msg = get_vocab("message_records");
	affiche_pop_up($msg,"admin");
}
// Affichage de la colonne de gauche
include_once "admin_col_gauche.php";

// Affichage du tableau de choix des sous-configuration
include_once "../include/admin_config_tableau.inc.php";

//echo "<h2>".get_vocab('admin_config2.php')."</h2>";

echo "<form action=\"./admin_config_etablissement.php\" method=\"get\" style=\"width: 100%;\">\n";


###########################################################
# Visualisation de la fiche de description d'une ressource.
###########################################################
# visu_fiche_description  = 0 : N'importe qui allant sur le site peut afficher la fiche de description d'une ressource, meme s'il n'est pas connecté
# visu_fiche_description  = 1 : Il faut obligatoirement se connecter pour voir la fiche de description d'une ressource, même en simple visiteur.
# visu_fiche_description  = 2 : Il faut obligatoirement se connecter et avoir le statut "utilisateur" pour voir la fiche de description d'une ressource
# visu_fiche_description  = 3 : Il faut obligatoirement se connecter et être au moins gestionnaire d'une ressource pour voir la fiche de description d'une ressource
# visu_fiche_description  = 4 : Il faut obligatoirement se connecter et être au moins administrateur du domaine pour voir la fiche de description d'une ressource du domaine.
# visu_fiche_description  = 5 : Il faut obligatoirement se connecter et être administrateur de site pour voir la fiche de description d'une ressource.
# visu_fiche_description  = 6 : Il faut obligatoirement se connecter et être administrateur général pour voir la fiche de description d'une ressource.
echo "<h3>".get_vocab("visu_fiche_description_msg")."</h3>\n";
echo "<table cellspacing=\"5\">\n";
echo "<tr><td>".get_vocab("visu_fiche_description0")."</td><td>\n";
echo "<input type='radio' name='visu_fiche_description' value='0' "; if (Settings::getEtab("visu_fiche_description")=='0') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description1")."</td><td>";
echo "<input type='radio' name='visu_fiche_description' value='1' "; if (Settings::getEtab("visu_fiche_description")=='1') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description2")."</td><td>";
echo "<input type='radio' name='visu_fiche_description' value='2' "; if (Settings::getEtab("visu_fiche_description")=='2') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description3")."</td><td>";
echo "<input type='radio' name='visu_fiche_description' value='3' "; if (Settings::getEtab("visu_fiche_description")=='3') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description4")."</td><td>";
echo "<input type='radio' name='visu_fiche_description' value='4' "; if (Settings::getEtab("visu_fiche_description")=='4') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
if (Settings::getEtab("module_multisite") == "Oui") {
  echo "<tr><td>".get_vocab("visu_fiche_description5")."</td><td>";
  echo "<input type='radio' name='visu_fiche_description' value='5' "; if (Settings::getEtab("visu_fiche_description")=='5') echo "checked=\"checked\""; echo " />\n";
  echo "</td></tr>\n";
}
echo "<tr><td>".get_vocab("visu_fiche_description6")."</td><td>\n";
echo "<input type='radio' name='visu_fiche_description' value='6' "; if (Settings::getEtab("visu_fiche_description")=='6') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "</table>\n";

###########################################################
# Visualisation de la fiche de réservatiob d'une ressource.
###########################################################
# acces_fiche_reservation  = 0 : N'importe qui allant sur le site, meme s'il n'est pas connecté
# acces_fiche_reservation  = 1 : Il faut obligatoirement se connecter, même en simple visiteur.
# acces_fiche_reservation  = 2 : Il faut obligatoirement se connecter et avoir le statut "utilisateur"
# acces_fiche_reservation  = 3 : Il faut obligatoirement se connecter et être au moins gestionnaire d'une ressource
# acces_fiche_reservation  = 4 : Il faut obligatoirement se connecter et être au moins administrateur du domaine
# acces_fiche_reservation  = 5 : Il faut obligatoirement se connecter et être administrateur de site
# acces_fiche_reservation  = 6 : Il faut obligatoirement se connecter et être administrateur général
echo "<hr /><h3>".get_vocab("acces_fiche_reservation_msg")."</h3>\n";
echo "<table cellspacing=\"5\">\n";
echo "<tr><td>".get_vocab("visu_fiche_description0")."</td><td>\n";
echo "<input type='radio' name='acces_fiche_reservation' value='0' "; if (Settings::getEtab("acces_fiche_reservation")=='0') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description1")."</td><td>";
echo "<input type='radio' name='acces_fiche_reservation' value='1' "; if (Settings::getEtab("acces_fiche_reservation")=='1') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description2")."</td><td>";
echo "<input type='radio' name='acces_fiche_reservation' value='2' "; if (Settings::getEtab("acces_fiche_reservation")=='2') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description3")."</td><td>";
echo "<input type='radio' name='acces_fiche_reservation' value='3' "; if (Settings::getEtab("acces_fiche_reservation")=='3') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("visu_fiche_description4")."</td><td>";
echo "<input type='radio' name='acces_fiche_reservation' value='4' "; if (Settings::getEtab("acces_fiche_reservation")=='4') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
if (Settings::getEtab("module_multisite") == "Oui") {
  echo "<tr><td>".get_vocab("visu_fiche_description5")."</td><td>";
  echo "<input type='radio' name='acces_fiche_reservation' value='5' "; if (Settings::getEtab("acces_fiche_reservation")=='5') echo "checked=\"checked\""; echo " />\n";
  echo "</td></tr>\n";
}
echo "<tr><td>".get_vocab("visu_fiche_description6")."</td><td>";
echo "<input type='radio' name='acces_fiche_reservation' value='6' "; if (Settings::getEtab("acces_fiche_reservation")=='6') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "</table>\n";

//Nombre max de de r�servations, toutes ressources confondues


//Suppression/Modification de réservations
# allow_user_delete_after_begin = 0 : un utilisateur ne peut pas supprimer ou modifier une réservation en cours ni créer une réservation sur un créneau "entamé".
# allow_user_delete_after_begin = 1 : un utilisateur peut supprimer, modifier ou créer dans certaines conditions une réservation en cours (et dont il est bénéficiaire) et créer une réservation sur un créneau "entamé".
# allow_user_delete_after_begin = 2 : un utilisateur peut modifier dans certaines conditions une réservation en cours (et dont il est bénéficiaire) et créer une r�servation sur un créneau "entamé" (mais pas supprimer ni créer) .
echo "<hr /><h3>".get_vocab("allow_user_delete_after_beginning_msg")."</h3>\n";
echo "<table cellspacing=\"5\">\n";
echo "<tr><td>".get_vocab("allow_user_delete_after_beginning0")."</td><td>\n";
echo "<input type='radio' name='allow_user_delete_after_begin' value='0' "; if (Settings::getEtab("allow_user_delete_after_begin")=='0') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("allow_user_delete_after_beginning1")."</td><td>";
echo "<input type='radio' name='allow_user_delete_after_begin' value='1' "; if (Settings::getEtab("allow_user_delete_after_begin")=='1') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("allow_user_delete_after_beginning2")."</td><td>";
echo "<input type='radio' name='allow_user_delete_after_begin' value='2' "; if (Settings::getEtab("allow_user_delete_after_begin")=='2') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "</table>\n";

# allow_gestionnaire_modify_delete=0 : un gestionnaire d'une ressource ne peut pas supprimer ou modifier les réservation effectuées sur la ressource, sauf celles dont il est l'auteur.
# allow_gestionnaire_modify_delete=1 : un gestionnaire d'une ressource peut supprimer ou modifier n'importe quelle réservation effectuées sur la ressource
echo "<hr />\n";
echo "<table cellspacing=\"5\">\n";
echo "<tr><td>".get_vocab("allow_gestionnaire_modify_del0")."</td><td>\n";
echo "<input type='radio' name='allow_gestionnaire_modify_del' value='0' "; if (Settings::getEtab("allow_gestionnaire_modify_del")=='0') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("allow_gestionnaire_modify_del1")."</td><td>";
echo "<input type='radio' name='allow_gestionnaire_modify_del' value='1' "; if (Settings::getEtab("allow_gestionnaire_modify_del")=='1') echo "checked=\"checked\""; echo " />\n";
echo "</td></tr>\n";
echo "</table>\n";

// Nombre max de réservations (toutes ressources)
echo "<hr />\n";
echo "<table cellspacing=\"5\">\n";
echo "<tr><td>".get_vocab("max_booking")." ";
echo " - ".get_vocab("all_rooms");
//echo grr_help("aide_grr_config_generale");
echo "</td><td><input type=\"text\" name=\"UserAllRoomsMaxBooking\" value=\"".Settings::getEtab("UserAllRoomsMaxBooking")."\" size=\"5\"/></td></tr>\n";
echo "</table>\n";

echo "<p><input type=\"hidden\" name=\"page_config\" value=\"2\" />\n";
// Modif CD - RECIA - 2014-05-28 : 
// alignement différent du bouton save pour intégration portail ENT
// Ancien code :
//echo "<br /></p><div id=\"fixe\" style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>\n";
// Nouveau code :
//echo "<br /></p><div style=\"text-align:right;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>\n";
// Fin modif RECIA
//echo "</form>\n";

// Nouveau code Bootstrap (bouton bleu flottant)
echo '<br />'.PHP_EOL;
echo '<br />'.PHP_EOL;
echo '</p>'.PHP_EOL;
//Modif pour ne plus centrer le bouton - CD - 20170831
//echo '<div id="fixe" style="text-align:center;">'.PHP_EOL;
echo '<div id="fixe">'.PHP_EOL;
echo '<input class="btn btn-primary" type="submit" name="ok" value="'.get_vocab('save').'" style="font-variant: small-caps;"/>'.PHP_EOL;
echo '</div>';
echo '</form>';

// fin de l'affichage de la colonne de droite
//echo "</td></tr></table>\n";
echo '</div></div>';
?>
