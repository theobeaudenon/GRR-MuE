<?php
/**
 * admin_config3.php
 * Interface permettant à l'administrateur la configuration de certains paramètres généraux
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-05-07 21:26:44 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config3.php,v 1.1 2010-05-07 21:26:44 grr Exp $
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
 * $Log: admin_config3.php,v $
 * Revision 1.1  2010-05-07 21:26:44  grr
 * *** empty log message ***
 *
 * Revision 1.9  2009-10-09 07:55:48  grr
 * *** empty log message ***
 *
 * Revision 1.8  2009-04-10 05:33:10  grr
 * *** empty log message ***
 *
 * Revision 1.6  2009-03-24 13:30:07  grr
 * *** empty log message ***
 *
 * Revision 1.5  2009-02-27 13:28:19  grr
 * *** empty log message ***
 *
 * Revision 1.4  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 *
 */
// javascript_info_disabled
if (isset($_GET['javascript_info_disabled'])) {
    if (!Settings::setEtab("javascript_info_disabled", $_GET['javascript_info_disabled'])) {
        echo "Erreur lors de l'enregistrement de javascript_info_disabled !<br />";
        die();
    }
}
// javascript_info_admin_disabled
if (isset($_GET['javascript_info_admin_disabled'])) {
    if (!Settings::setEtab("javascript_info_admin_disabled", $_GET['javascript_info_admin_disabled'])) {
        echo "Erreur lors de l'enregistrement de javascript_info_admin_disabled !<br />";
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

echo "<form action=\"./admin_config_etablissement.php\"  method=\"get\" style=\"width: 100%;\">\n";


# Désactive les messages javascript (pop-up) après la création/modificatio/suppression d'une réservation
# 1 = Oui, 0 = Non
echo "\n<h3>".get_vocab("javascript_info_disabled_msg")."</h3>";
echo "\n<table cellspacing=\"5\">";
echo "\n<tr><td>".get_vocab("javascript_info_disabled0")."</td><td>";
echo "\n<input type='radio' name='javascript_info_disabled' value='0' "; if (Settings::getEtab("javascript_info_disabled")=='0') echo "checked=\"checked\""; echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("javascript_info_disabled1")."</td><td>";
echo "\n<input type='radio' name='javascript_info_disabled' value='1' "; if (Settings::getEtab("javascript_info_disabled")=='1') echo "checked=\"checked\""; echo " />";
echo "\n</td></tr>";
echo "\n</table>";

# Désactive les messages javascript d'information (pop-up) dans les menus d'administration
# 1 = Oui, 0 = Non
echo "\n<hr /><h3>".get_vocab("javascript_info_admin_disabled_msg")."</h3>";
echo "\n<table cellspacing=\"5\">";
echo "\n<tr><td>".get_vocab("javascript_info_admin_disabled0")."</td><td>";
echo "\n<input type='radio' name='javascript_info_admin_disabled' value='0' "; if (Settings::getEtab("javascript_info_admin_disabled")=='0') echo "checked=\"checked\""; echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("javascript_info_disabled1")."</td><td>";
echo "\n<input type='radio' name='javascript_info_admin_disabled' value='1' "; if (Settings::getEtab("javascript_info_admin_disabled")=='1') echo "checked=\"checked\""; echo " />";
echo "\n</td></tr>";
echo "\n</table>";

// Modif CD - RECIA - 2014-05-28 : 
// alignement différent du bouton save pour intégration portail ENT
// Ancien code :
//echo "\n<br /></p><div id=\"fixe\"  style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
//echo "<br /><br /></p><div id=\"fixe\" style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
// Nouveau code :
//echo "\n<br /></p><div style=\"text-align:right;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
// Fin modif RECIA
//echo "\n</form>";

echo "<p><input type=\"hidden\" name=\"page_config\" value=\"3\" />\n";

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
//echo "\n</td></tr></table>";
echo '</div></div>';
?>
