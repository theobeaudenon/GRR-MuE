<?php
/**
 * admin_config5.php
 * Interface permettant à l'administrateur la configuration des paramètres pour le module Jours Cycles
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-05-07 21:26:44 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config5.php,v 1.1 2010-05-07 21:26:44 grr Exp $
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
 * $Log: admin_config5.php,v $
 * Revision 1.1  2010-05-07 21:26:44  grr
 * *** empty log message ***
 *
 * Revision 1.8  2009-04-14 12:59:17  grr
 * *** empty log message ***
 *
 * Revision 1.7  2009-04-09 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.6  2009-02-27 13:28:19  grr
 * *** empty log message ***
 *
 * Revision 1.5  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 *
 */

if (!Settings::load())
    die("Erreur chargement settings");

// Met à jour dans la BD le champ qui détermine si les fonctionnalités Jours/Cycles sont activées ou désactivées
if (isset($_GET['jours_cycles'])) {
    if (!Settings::setEtab("jours_cycles_actif", $_GET['jours_cycles'])) {
        echo "Erreur lors de l'enregistrement de jours_cycles_actif ! <br />";
    }
}

// Met à jour dans la BD du champ qui détermine si la fonctionnalité "multisite" est activée ou non
if (isset($_GET['module_multisite'])) {
    if (!Settings::setEtab("module_multisite", $_GET['module_multisite'])) {
        echo "Erreur lors de l'enregistrement de module_multisite ! <br />";
        die();
    }
}

// use_fckeditor
if (isset($_GET['use_fckeditor'])) {
    if (!Settings::setEtab("use_fckeditor", $_GET['use_fckeditor'])) {
        echo "Erreur lors de l'enregistrement de use_fckeditor !<br />";
        die();
    }
}

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

//
// Configurations du nombre de jours par Cycle et du premier jour du premier Jours/Cycles
//******************************
//
echo "<form action=\"./admin_config_etablissement.php\"  method=\"get\" style=\"width: 100%;\" onsubmit=\"return verifierJoursCycles(false);\">\n";
echo "<h3>".get_vocab("Activer_module_jours_cycles")./*grr_help("aide_grr_jours_cycle").*/"</h3>\n";
echo "<table border='0'>\n<tr>\n<td>\n";
echo get_vocab("Activer_module_jours_cycles").get_vocab("deux_points");
echo "<select name='jours_cycles'>\n";
if (Settings::getEtab("jours_cycles_actif") == "Oui") {
    echo "<option value=\"Oui\" selected=\"selected\">".get_vocab('YES')."</option>\n";
    echo "<option value=\"Non\">".get_vocab('NO')."</option>\n";
} else {
    echo "<option value=\"Oui\">".get_vocab('YES')."</option>\n";
    echo "<option value=\"Non\" selected=\"selected\">".get_vocab('NO')."</option>\n";
}
echo "</select>\n</td>\n</tr>\n</table><hr />\n";


echo "<h3>".get_vocab("Activer_module_multisite")./*grr_help("aide_grr_multisites").*/"</h3>\n";
echo "<table border='0'>\n<tr>\n<td>\n";
echo get_vocab("Activer_module_multisite").get_vocab("deux_points");
echo "<select name='module_multisite'>\n";
if (Settings::getEtab("module_multisite") == "Oui") {
    echo "<option value=\"Oui\" selected=\"selected\">".get_vocab('YES')."</option>\n";
    echo "<option value=\"Non\">".get_vocab('NO')."</option>\n";
} else {
    echo "<option value=\"Oui\">".get_vocab('YES')."</option>\n";
    echo "<option value=\"Non\" selected=\"selected\">".get_vocab('NO')."</option>\n";
}
echo "</select>\n</td>\n</tr>\n</table>\n";


# La page de modification de la configuration d'une ressource utilise pour le champ "description complète"
# l'application FckEditor permettant une mise en forme "wysiwyg" de la page.
# "0" pour ne pas utiliser cette application (le répertoire "fckeditor" et tout ce qu'il contient n'est alors pas nécessaire au bon fonctionnement de GRR).
echo "\n<hr /><h3>".get_vocab("use_fckeditor_msg")."</h3>";
echo "\n<p>".get_vocab("use_fckeditor_explain")."</p>";
echo "\n<table>";
echo "\n<tr><td>".get_vocab("use_fckeditor0")."</td><td>";
echo "\n<input type='radio' name='use_fckeditor' value='0' "; if (Settings::getEtab("use_fckeditor")=='0') echo "checked=\"checked\""; echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("use_fckeditor1")."</td><td>";
echo "\n<input type='radio' name='use_fckeditor' value='1' "; if (Settings::getEtab("use_fckeditor")=='1') echo "checked=\"checked\""; echo " />";
echo "\n</td></tr>";
echo "\n</table>";

// Modif CD - RECIA - 2014-05-28 : 
// alignement différent du bouton save pour intégration portail ENT
// Ancien code :
//echo "\n<div id=\"fixe\" style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/>\n";
// Nouveau code :
//echo "\n<div style=\"text-align:right;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/>\n";
// Fin modif RECIA

//Modif d'affichage - CD - 20170831
//echo "<input type=\"hidden\" value=\"5\" name=\"page_config\" /></div>\n";
echo "<input type=\"hidden\" value=\"5\" name=\"page_config\" />\n";
//echo "</form>";

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
//echo "</td></tr></table>";
echo '</div></div>';
?>
