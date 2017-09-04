<?php
/**
 * admin_config_etablissement1.php
 * Interface permettant à l'administrateur la configuration de certains paramètres généraux
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-11-24 20:52:41 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config1.php,v 1.2 2010-11-24 20:52:41 grr Exp $
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

if (isset($_POST['message_accueil'])) {
    if (!Settings::setEtab("message_accueil", $_POST['message_accueil'])) {
        echo "Erreur lors de l'enregistrement de message_accueil !<br />";
        die();
    }
}

// Style/thème
if (isset($_POST['default_css'])) {
    if (!Settings::setEtab("default_css", $_POST['default_css'])) {
        echo "Erreur lors de l'enregistrement de default_css !<br />";
        die();
    }
}

// langage
if (isset($_POST['default_language'])) {
    if (!Settings::setEtab("default_language", $_POST['default_language'])) {
        echo "Erreur lors de l'enregistrement de default_language !<br />";
        die();
    }
    unset ($_SESSION['default_language']);

}

// Type d'affichage des listes des domaines et des ressources
if (isset($_POST['area_list_format'])) {
    if (!Settings::setEtab("area_list_format", $_POST['area_list_format'])) {
        echo "Erreur lors de l'enregistrement de area_list_format !<br />";
        die();
    }
}

// site par défaut
if (isset($_POST['id_site'])) {
    if (!Settings::setEtab("default_site", $_POST['id_site'])) {
        echo "Erreur lors de l'enregistrement de default_site !<br />";
        die();
    }
}

// domaine par défaut
if (isset($_POST['id_area'])) {
    if (!Settings::setEtab("default_area", $_POST['id_area'])) {
        echo "Erreur lors de l'enregistrement de default_area !<br />";
        die();
    }
}
if (isset($_POST['id_room'])) {
    if (!Settings::setEtab("default_room", $_POST['id_room'])) {
        echo "Erreur lors de l'enregistrement de default_room !<br />";
        die();
    }
}

// Affichage de l'adresse email
if (isset($_POST['display_level_email'])) {
    if (!Settings::setEtab("display_level_email", $_POST['display_level_email'])) {
        echo "Erreur lors de l'enregistrement de display_level_email !<br />";
        die();
    }
}

// display_info_bulle
if (isset($_POST['display_info_bulle'])) {
    if (!Settings::setEtab("display_info_bulle", $_POST['display_info_bulle'])) {
        echo "Erreur lors de l'enregistrement de display_info_bulle !<br />";
        die();
    }
}

// display_full_description
if (isset($_POST['display_full_description'])) {
    if (!Settings::setEtab("display_full_description", $_POST['display_full_description'])) {
        echo "Erreur lors de l'enregistrement de display_full_description !<br />";
        die();
    }
}

// display_short_description
if (isset($_POST['display_short_description'])) {
    if (!Settings::setEtab("display_short_description", $_POST['display_short_description'])) {
        echo "Erreur lors de l'enregistrement de display_short_description !<br />";
        die();
    }
}

// remplissage de la description brève
if (isset($_POST['remplissage_description_breve'])) {
    if (!Settings::setEtab("remplissage_description_breve", $_POST['remplissage_description_breve'])) {
        echo "Erreur lors de l'enregistrement de remplissage_description_breve !<br />";
        die();
    }
}

// pview_new_windows
if (isset($_POST['pview_new_windows'])) {
    if (!Settings::setEtab("pview_new_windows", $_POST['pview_new_windows'])) {
        echo "Erreur lors de l'enregistrement de pview_new_windows !<br />";
        die();
    }
}

if (isset($_POST['longueur_liste_ressources_max'])) {
    settype($_POST['longueur_liste_ressources_max'],"integer");
    if ($_POST['longueur_liste_ressources_max'] <=0) $_POST['longueur_liste_ressources_max'] = 1;
    if (!Settings::setEtab("longueur_liste_ressources_max", $_POST['longueur_liste_ressources_max'])) {
        echo "Erreur lors de l'enregistrement de longueur_liste_ressources_max !<br />";
        die();
    }
}

// nombre de calendriers
if (isset($_POST['nb_calendar'])) {
    settype($_POST['nb_calendar'],"integer");
    if (!Settings::setEtab("nb_calendar", $_POST['nb_calendar'])) {
        echo "Erreur lors de l'enregistrement de nb_calendar !<br />";
        die();
    }
}

$demande_confirmation = 'no';
if (isset($_POST['begin_day']) and isset($_POST['begin_month']) and isset($_POST['begin_year'])) {
    while (!checkdate($_POST['begin_month'],$_POST['begin_day'],$_POST['begin_year']))
        $_POST['begin_day']--;
    $begin_bookings = mktime(0,0,0,$_POST['begin_month'],$_POST['begin_day'],$_POST['begin_year']);

    $sqlJoin = " JOIN ".TABLE_PREFIX."_room AS R on R.id = E.room_id 
				JOIN ".TABLE_PREFIX."_j_site_area AS SA ON R.area_id = SA.id_area
				JOIN ".TABLE_PREFIX."_j_etablissement_site AS ES ON ES.id_site = SA.id_site ";
    $idEtablissement = getIdEtablissementCourant();

	$test_del1 = grr_sql_count(grr_sql_query("select * from ".TABLE_PREFIX."_entry AS E ".$sqlJoin." WHERE (end_time < '$begin_bookings' ) AND ES.id_etablissement = $idEtablissement"));
    $test_del2 = grr_sql_count(grr_sql_query("select * from ".TABLE_PREFIX."_repeat AS E ".$sqlJoin." WHERE (end_date < '$begin_bookings') AND ES.id_etablissement = $idEtablissement"));

	if (($test_del1!=0) or ($test_del2!=0)) {
        $demande_confirmation = 'yes';
    } else {
        if (!Settings::setEtab("begin_bookings", $begin_bookings))
        echo "Erreur lors de l'enregistrement de begin_bookings !<br />";
    }

}
if (isset($_POST['end_day']) and isset($_POST['end_month']) and isset($_POST['end_year'])) {
    while (!checkdate($_POST['end_month'],$_POST['end_day'],$_POST['end_year']))
        $_POST['end_day']--;
    $end_bookings = mktime(0,0,0,$_POST['end_month'],$_POST['end_day'],$_POST['end_year']);
    if ($end_bookings < $begin_bookings) $end_bookings = $begin_bookings;

    $sqlJoin = " JOIN ".TABLE_PREFIX."_room AS R on R.id = E.room_id
				JOIN ".TABLE_PREFIX."_j_site_area AS SA ON R.area_id = SA.id_area
				JOIN ".TABLE_PREFIX."_j_etablissement_site AS ES ON ES.id_site = SA.id_site ";
    $idEtablissement = getIdEtablissementCourant();
	
	$test_del1 = grr_sql_count(grr_sql_query("select * from ".TABLE_PREFIX."_entry AS E ".$sqlJoin." WHERE (start_time > '$end_bookings' ) AND ES.id_etablissement = $idEtablissement"));
    $test_del2 = grr_sql_count(grr_sql_query("select * from ".TABLE_PREFIX."_repeat AS E ".$sqlJoin." WHERE (start_time > '$end_bookings') AND ES.id_etablissement = $idEtablissement"));
   
    if (($test_del1!=0) or ($test_del2!=0)) {
        $demande_confirmation = 'yes';
    } else {
        if (!Settings::setEtab("end_bookings", $end_bookings))
        echo "Erreur lors de l'enregistrement de end_bookings !<br />";
    }


}

$idEtablissement = getIdEtablissementCourant();
if ($demande_confirmation == 'yes') {
    header("Location: ./admin_confirm_change_date_bookings.php?end_bookings=$end_bookings&begin_bookings=$begin_bookings&id_etablissement=$idEtablissement");
    die();
}

if (!Settings::load())
    die("Erreur chargement settings");

// Si pas de problème, message de confirmation
if (isset($_POST['ok'])) {
	$_SESSION['displ_msg'] = 'yes';
    if ($msg == '') $msg = get_vocab("message_records");
	Header("Location: "."admin_config_etablissement.php?msg=".$msg);
	exit();
}

if ((isset($_GET['msg'])) and isset($_SESSION['displ_msg']) and ($_SESSION['displ_msg']=='yes'))  {
   $msg = $_GET['msg'];
}
else
   $msg = '';

// Utilisation de la bibliothèque prototype dans ce script
$use_prototype = 'y';

# print the page header
//print_header("","","","",$type="with_session", $page="admin");
print_header('', '', '', $type = 'with_session');
affiche_pop_up($msg,"admin");

// Affichage de la colonne de gauche
include_once "admin_col_gauche.php";

// Affichage du tableau de choix des sous-configuration
include_once "../include/admin_config_tableau.inc.php";


//
// Config générale
//****************
//
echo "<form enctype=\"multipart/form-data\" action=\"./admin_config_etablissement.php\" id=\"nom_formulaire\" method=\"post\" style=\"width: 100%;\">";
echo "<h3>".get_vocab("miscellaneous")."</h3>\n";
?>

<?php
echo "<h3>".get_vocab("affichage_calendriers")."</h3>\n";
echo "<p>".get_vocab("affichage_calendriers_msg").get_vocab("deux_points");
echo "<select name=\"nb_calendar\" >\n";
for ($k=0;$k<6;$k++) {
  echo "<option value=\"".$k."\" ";
  if (Settings::get("nb_calendar") == $k)
    echo " selected=\"selected\" ";
  echo ">".$k."</option>\n";
}
echo "</select></p>";


if (Settings::get("use_fckeditor") == 1) {
   	echo "<script type=\"text/javascript\" src=\"../js/ckeditor/ckeditor.js\"></script>\n";
}
echo "<h3>".get_vocab("message perso")."</h3>\n";
echo "<p>".get_vocab("message perso explain");
if (Settings::get("use_fckeditor") != 1)
    echo " ".get_vocab("description complete2");
if (Settings::get("use_fckeditor") == 1) {
      echo "<textarea class=\"ckeditor\" id=\"editor1\" name=\"message_accueil\" rows=\"8\" cols=\"120\">\n";
      echo htmlspecialchars(Settings::get('message_accueil'));
      echo "</textarea>\n";
?>
      <script type="text/javascript">
		//<![CDATA[
			CKEDITOR.replace( 'editor1',
				{
					toolbar :
	[
	 ['Source'],
   ['Cut','Copy','Paste','PasteText','PasteFromWord', 'SpellChecker', 'Scayt'],
   ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
   ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
   ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
   ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   ['Link','Unlink','Anchor'],
   ['Image','Table','HorizontalRule','SpecialChar','PageBreak'],
  	]
				});

		//]]>
		</script>
<?php
    } else {
        echo "\n<textarea name=\"message_accueil\" rows=\"8\" cols=\"120\">".htmlspecialchars(Settings::get('message_accueil'))."</textarea>\n";
    }
echo "</p>";



//
// Début et fin des réservations
//******************************
//
echo "<hr /><h3>".get_vocab("title_begin_end_bookings")."</h3>\n";
?>
<table border='0'>
<tr><td><?php echo get_vocab("begin_bookings"); ?></td><td>
<?php
$bday = strftime("%d", Settings::getEtab("begin_bookings"));
$bmonth = strftime("%m", Settings::getEtab("begin_bookings"));
$byear = strftime("%Y", Settings::getEtab("begin_bookings"));
genDateSelector("begin_", $bday, $bmonth, $byear,"more_years") ?>
</td>
<td>&nbsp;</td>
</tr>
</table>
<?php echo "<p><i>".get_vocab("begin_bookings_explain")."</i>";

?>
<br /><br /></p>
<table border='0'>
<tr><td><?php echo get_vocab("end_bookings"); ?></td><td>
<?php
$eday = strftime("%d", Settings::getEtab("end_bookings"));
$emonth = strftime("%m", Settings::getEtab("end_bookings"));
$eyear= strftime("%Y", Settings::getEtab("end_bookings"));
genDateSelector("end_",$eday,$emonth,$eyear,"more_years") ?>
</td>
</tr>
</table>
<?php echo "<p><i>".get_vocab("end_bookings_explain")."</i></p>";
//
// Configuration de l'affichage par défaut
//****************************************
//
?>
<hr />
<?php echo "<h3>".get_vocab("default_parameter_values_title")."</h3>\n";
echo "<p>".get_vocab("explain_default_parameter")."</p>";
//
// Choix du type d'affichage
//
echo "<h4>".get_vocab("explain_area_list_format")."</h4>";
echo "<table><tr><td>".get_vocab("liste_area_list_format")."</td><td>";
echo "<input type='radio' name='area_list_format' value='list' "; if (Settings::get("area_list_format")=='list') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("select_area_list_format")."</td><td>";
echo "<input type='radio' name='area_list_format' value='select' "; if (Settings::get("area_list_format")=='select') echo "checked=\"checked\""; echo " />";
echo "</td></tr></table>";

//
// Choix du domaine et de la ressource
// http://www.phpinfo.net/articles/article_listes.html
//
 if (Settings::get("module_multisite") == "Oui")
   $use_site='y';
 else
   $use_site='n';
 
 $use_etab='y';
 $idEtablissement = getIdEtablissementCourant();
 
?>
 <script type="text/javascript">
 
	function modifier_liste_domaines(action){

		$.ajax({
			url: "../my_account_modif_listes.php",
			type: "get",
			dataType: "html",
			data: {
				id_site: $('#id_site').val(),
				type:'domaine',
				default_area : '<?php echo Settings::get('default_area'); ?>',
				session_login:'<?php echo getUserName(); ?>',
				use_site:'<?php echo $use_site; ?>',
				use_etab:'<?php echo $use_etab; ?>',
                id_etab:'<?php echo $idEtablissement?>',
				action:action
			},
			success: function(returnData){
				$("#div_liste_domaines").html(returnData);
			},
			error: function(e){
				console.log(e);
			}
		});
	}
	
 /*function modifier_liste_domaines(action){
    new Ajax.Updater(
        $('div_liste_domaines'),
        "../my_account_modif_listes.php",
        {
            method: 'get', 
            parameters: 
                $('id_site').serialize(true)+'&'+
                'type=domaine'+'&'+
                'default_area=<?php echo Settings::get("default_area"); ?>'+'&'+
                'session_login=<?php echo getUserName(); ?>'+'&'+
                'use_site=<?php echo $use_site; ?>'+'&'+
                'use_etab=<?php echo $use_etab; ?>'+'&'+
                'id_etab=<?php echo $idEtablissement?> '+'&'+
                'action='+action 
		});
 }*/
 
 function modifier_liste_ressources(action){
		$.ajax({
			url: "../my_account_modif_listes.php",
			type: "get",
			dataType: "html",
			data: {
				id_area:$('#id_area').val(),
				type:'ressource',
				default_room : '<?php echo Settings::get('default_room'); ?>',
				session_login:'<?php echo getUserName(); ?>',
				action:action,
			},
			success: function(returnData){
				$("#div_liste_ressources").html(returnData);
			},
			error: function(e){
				console.log(e);
			}
		});
	}
	
 /*function modifier_liste_ressources(action){
     new Ajax.Updater(
        $('div_liste_ressources'),
        "../my_account_modif_listes.php",
        {
            method: 'get', 
            parameters: 
                $('id_area').serialize(true)+'&'+
                'type=ressource'+'&'+
                'default_room=<?php echo Settings::get("default_room"); ?>'+'&'+
                'session_login=<?php echo getUserName(); ?>'+'&'+
                'action='+action 
        });
 }*/
 </script>
 <?php
if (Settings::get("module_multisite") == "Oui")
  echo ('
      <h4>'.get_vocab('explain_default_area_and_room_and_site').'</h4>');
else
  echo ('
      <h4>'.get_vocab('explain_default_area_and_room').'</h4>');
/**
 * Liste des sites
 */
 if (Settings::get("module_multisite") == "Oui") {
   $sql = "SELECT S.id,S.sitecode,S.sitename
           FROM ".TABLE_PREFIX."_site AS S 
           INNER JOIN ".TABLE_PREFIX."_j_etablissement_site AS ES
           ON ES.id_site = S.id
           WHERE ES.id_etablissement = $idEtablissement
           ORDER BY id ASC";
   $resultat = grr_sql_query($sql);
   echo('
      <table>
        <tr><td></div><table><tr>
          <td>'.get_vocab('default_site').get_vocab('deux_points').'</td>
          <td>
            <select class="form-control" id="id_site" name="id_site" onchange="modifier_liste_domaines(\'actualiser\');modifier_liste_ressources(\'actualiser\')">
              <option value="-1">'.get_vocab('choose_a_site').'</option>'."\n");
  for ($enr = 0; ($row = grr_sql_row($resultat, $enr)); $enr++){
      echo '              <option value="'.$row[0].'"';
      if (Settings::get("default_site") == $row[0])
        echo ' selected="selected" ';
      echo '>'.htmlspecialchars($row[2]);
      echo '</option>'."\n";
  }
  echo('            </select>
          </td>
        </tr></table></div></td></tr>');
} else {
 echo '<input type="hidden" id="id_site" name="id_site" value="-1" />
       <table>';
}


// ----------------------------------------------------------------------------
// Liste domaines
// ----------------------------------------------------------------------------
/**
  * Liste des domaines
 */
echo '<tr><td colspan="2">';
echo '<div id="div_liste_domaines">';
// Ici, on insère la liste des domaines avec de l'ajax !
echo '</div></td></tr>';

/**
 * Liste des ressources
 */
echo '<tr><td colspan="2">';
echo '<div id="div_liste_ressources">';
echo '<input type="hidden" id="id_area" name="id_area" value="'.Settings::get("default_area").'" />';
// Ici, on insère la liste des ressouces avec de l'ajax !
echo '</div></td></tr></table>';

// Au chargement de la page, on remplit les listes de domaine et de ressources
echo '<script type="text/javascript">modifier_liste_domaines(\'actualiser\');</script>'."\n";
echo '<script type="text/javascript">modifier_liste_ressources(\'actualiser\');</script>'."\n";

//
// Choix de la feuille de style
//
if (authGetUserLevel(getUserName(),-1) > 6){
	echo "<h4>".get_vocab("explain_css")."</h4>";
	echo "<table><tr><td>".get_vocab("choose_css")."</td><td>";
	echo "<select class='form-control' name='default_css'>\n";
	$i=0;
	while ($i < count($liste_themes)) {
	   echo "<option value='".$liste_themes[$i]."'";
	   if (Settings::get("default_css") == $liste_themes[$i]) echo " selected=\"selected\"";
	   echo " >".encode_message_utf8($liste_name_themes[$i])."</option>";
	   $i++;
	}
	echo "</select></td></tr></table>\n";
	}
//
// Choix de la langue
//
echo "<h4>".get_vocab("choose_language")."</h4>";
echo "<table><tr><td>".get_vocab("choose_css")."</td><td>";
echo "<select class='form-control' name='default_language'>\n";
$i=0;
while ($i < count($liste_language)) {
   echo "<option value='".$liste_language[$i]."'";
   if (Settings::get("default_language") == $liste_language[$i]) echo " selected=\"selected\"";
   echo " >".encode_message_utf8($liste_name_language[$i])."</option>\n";
   $i++;
}
echo "</select></td></tr></table>\n";

#
# Affichage du contenu des "info-bulles" des réservations, dans les vues journées, semaine et mois.
# display_info_bulle = 0 : pas d'info-bulle.
# display_info_bulle = 1 : affichage des noms et prénoms du bénéficiaire de la réservation.
# display_info_bulle = 2 : affichage de la description complète de la réservation.
echo "<hr /><h3>".get_vocab("display_info_bulle_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("info-bulle0")."</td><td>";
echo "<input type='radio' name='display_info_bulle' value='0' "; if (Settings::get("display_info_bulle")=='0') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("info-bulle1")."</td><td>";
echo "<input type='radio' name='display_info_bulle' value='1' "; if (Settings::get("display_info_bulle")=='1') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("info-bulle2")."</td><td>";
echo "<input type='radio' name='display_info_bulle' value='2' "; if (Settings::get("display_info_bulle")=='2') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "</table>";

# Afficher la description complète de la réservation dans les vues semaine et mois.
# display_full_description=1 : la description complète s'affiche.
# display_full_description=0 : la description complète ne s'affiche pas.
echo "<hr /><h3>".get_vocab("display_full_description_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("display_full_description0")."</td><td>";
echo "<input type='radio' name='display_full_description' value='0' "; if (Settings::get("display_full_description")=='0') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_full_description1")."</td><td>";
echo "<input type='radio' name='display_full_description' value='1' "; if (Settings::get("display_full_description")=='1') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "</table>";

# Afficher la description courte de la réservation dans les vues semaine et mois.
# display_short_description=1 : la description  s'affiche.
# display_short_description=0 : la description  ne s'affiche pas.
echo "<hr /><h3>".get_vocab("display_short_description_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("display_short_description0")."</td><td>";
echo "<input type='radio' name='display_short_description' value='0' "; if (Settings::get("display_short_description")=='0') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_short_description1")."</td><td>";
echo "<input type='radio' name='display_short_description' value='1' "; if (Settings::get("display_short_description")=='1') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "</table>";

###########################################################
# Affichage des  adresses email dans la fiche de réservation
###########################################################
# Qui peut voir les adresse email ?
# display_level_email  = 0 : N'importe qui allant sur le site, meme s'il n'est pas connecté
# display_level_email  = 1 : Il faut obligatoirement se connecter, même en simple visiteur.
# display_level_email  = 2 : Il faut obligatoirement se connecter et avoir le statut "utilisateur"
# display_level_email  = 3 : Il faut obligatoirement se connecter et être au moins gestionnaire d'une ressource
# display_level_email  = 4 : Il faut obligatoirement se connecter et être au moins administrateur du domaine
# display_level_email  = 5 : Il faut obligatoirement se connecter et être administrateur de site
# display_level_email  = 6 : Il faut obligatoirement se connecter et être administrateur général
echo "<hr /><h3>".get_vocab("display_level_email_msg1")."</h3>\n";
echo "<p>".get_vocab("display_level_email_msg2")."</p>";
echo "<table cellspacing=\"5\">";
echo "<tr><td>".get_vocab("visu_fiche_description0")."</td><td>";
echo "<input type='radio' name='display_level_email' value='0' "; if (Settings::get("display_level_email")=='0') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description1")."</td><td>";
echo "<input type='radio' name='display_level_email' value='1' "; if (Settings::get("display_level_email")=='1') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description2")."</td><td>";
echo "<input type='radio' name='display_level_email' value='2' "; if (Settings::get("display_level_email")=='2') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description3")."</td><td>";
echo "<input type='radio' name='display_level_email' value='3' "; if (Settings::get("display_level_email")=='3') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description4")."</td><td>";
echo "<input type='radio' name='display_level_email' value='4' "; if (Settings::get("display_level_email")=='4') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
if (Settings::get("module_multisite") == "Oui") {
  echo "<tr><td>".get_vocab("visu_fiche_description5")."</td><td>";
  echo "<input type='radio' name='display_level_email' value='5' "; if (Settings::get("display_level_email")=='5') echo "checked=\"checked\""; echo " />";
  echo "</td></tr>";
}
echo "<tr><td>".get_vocab("visu_fiche_description6")."</td><td>";
echo "<input type='radio' name='display_level_email' value='6' "; if (Settings::get("display_level_email")=='6') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "</table>";



# Remplissage de la description courte
echo "<hr /><h3>".get_vocab("remplissage_description_breve_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("remplissage_description_breve0")."</td><td>";
echo "<input type='radio' name='remplissage_description_breve' value='0' "; if (Settings::get("remplissage_description_breve")=='0') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("remplissage_description_breve1")."</td><td>";
echo "<input type='radio' name='remplissage_description_breve' value='1' "; if (Settings::get("remplissage_description_breve")=='1') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("remplissage_description_breve2")."</td><td>";
echo "<input type='radio' name='remplissage_description_breve' value='2' "; if (Settings::get("remplissage_description_breve")=='2') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "</table>";

# Ouvrir les pages au format imprimable dans une nouvelle fenêtre du navigateur (0 pour non et 1 pour oui)
echo "<hr /><h3>".get_vocab("pview_new_windows_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("pview_new_windows0")."</td><td>";
echo "<input type='radio' name='pview_new_windows' value='0' "; if (Settings::get("pview_new_windows")=='0') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("pview_new_windows1")."</td><td>";
echo "<input type='radio' name='pview_new_windows' value='1' "; if (Settings::get("pview_new_windows")=='1') echo "checked=\"checked\""; echo " />";
echo "</td></tr>";
echo "</table>";


# Formulaire de réservation
echo "</p><hr /><h3>".get_vocab("formulaire_reservation")."</h3>\n";
echo "<p>".get_vocab("longueur_liste_ressources").get_vocab("deux_points")."
<input type=\"text\" name=\"longueur_liste_ressources_max\" value=\"".Settings::get("longueur_liste_ressources_max")."\" size=\"5\" />";

/*
# nb_year_calendar permet de fixer la plage de choix de l'année dans le choix des dates de début et fin des réservations
# La plage s'étend de année_en_cours - $nb_year_calendar à année_en_cours + $nb_year_calendar
# Par exemple, si on fixe $nb_year_calendar = 5 et que l'on est en 2005, la plage de choix de l'année s'étendra de 2000 à 2010
echo "<hr /><h3>".get_vocab("nb_year_calendar_msg")."</h3>\n";
echo get_vocab("nb_year_calendar_explain").get_vocab("deux_points");
echo "<select name=\"nb_year_calendar\" size=\"1\">\n";
$i = 1;
while ($i < 101) {
    echo "<option value=\".$i.\"";
    if (Settings::get("nb_year_calendar") == $i) echo " selected=\"selected\" ";
    echo ">".(date("Y") - $i)." - ".(date("Y") + $i)."</option>\n";
    $i++;
}
echo "</select>\n";
*/

// Modif CD - RECIA - 2014-05-28 : 
// alignement différent du bouton save pour intégration portail ENT
// Ancien code :
//echo "<br /><br /></p><div id=\"fixe\" style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
// Nouveau code :
//echo "<br /><br /></p><div style=\"text-align:right;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
// Fin modif RECIA
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

?>
<script type="text/javascript">
document.getElementById('title_home_page').focus();
</script>
<?php

// fin de l'affichage de la colonne de droite
//echo "</td></tr></table>";
echo '</div></div>';
?>
