<?php
/**
 * admin_type_modify.php
 * interface de création/modification des types de réservations
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-05-07 21:26:44 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_type_modify.php,v 1.1 2010-05-07 21:26:44 grr Exp $
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
 */
/**
 * $Log: admin_type_modify.php,v $
 * Revision 1.1  2010-05-07 21:26:44  grr
 * *** empty log message ***
 *
 * Revision 1.8  2010-03-03 14:41:34  grr
 * *** empty log message ***
 *
 * Revision 1.7  2009-04-14 12:59:17  grr
 * *** empty log message ***
 *
 * Revision 1.6  2009-04-09 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.5  2009-03-24 13:30:07  grr
 * *** empty log message ***
 *
 * Revision 1.4  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 *
 */

include_once "../include/admin.inc.php";
$grr_script_name = "admin_type_etablissement_modify.php";
$ok = NULL;
$back = '';
if (isset($_SERVER['HTTP_REFERER'])) $back = htmlspecialchars($_SERVER['HTTP_REFERER']);
if(authGetUserLevel(getUserName(),-1) < 6)
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
    showAccessDenied($day, $month, $year, '',$back);
    exit();
}


// Initialisation
$id_type = isset($_GET["id_type"]) ? $_GET["id_type"] : 0;
$type_name = isset($_GET["type_name"]) ? $_GET["type_name"] : NULL;
$order_display = isset($_GET["order_display"]) ? $_GET["order_display"] : NULL;
$type_letter = isset($_GET["type_letter"]) ? $_GET["type_letter"] : NULL;
$couleur = isset($_GET["couleur"]) ? $_GET["couleur"] : NULL;
$disponible = isset($_GET["disponible"]) ? $_GET["disponible"] : NULL;
$id_etablissement = getIdEtablissementCourant();
$msg ='';
if (isset($_GET["change_room_and_back"])) {
    $_GET['change_type'] = "yes";
    $_GET['change_done'] = "yes";
}


// Enregistrement
if (isset($_GET['change_type'])) {
	
    $_SESSION['displ_msg'] = "yes";
	
    if ($type_name == ''){
		$type_name = "A définir";
	}

    ///////////////////////////////////////////////////
    // GIP RECIA | DEBUT | 2013-03-26
    //if ($type_letter == '') $type_letter = 'A'; // Ancien code
    
    // Nouveau code :
    if ($type_letter == '') {
        if($id_type != 0) { // si mise à jour
            $type_letter = grr_sql_query1("select type_letter from ".TABLE_PREFIX."_type_area where id = '".$id_type."'");
        } else { // si création
            $type_letter = grr_sql_query1("select max(type_letter * 1) + 1 from ".TABLE_PREFIX."_type_area");
        }
    }
    // GIP RECIA | FIN
    ///////////////////////////////////////////////////

    if ($couleur == '') $couleur = "1";
    if ($disponible == '') $disponible = "2";
    
	if ($id_type>0){
		
        // Test sur $type_letter
        $test = grr_sql_query1("select count(id) from ".TABLE_PREFIX."_type_area where type_letter='".$type_letter."' and id!='".$id_type."'");
        if ($test > 0) {
            $msg = "Enregistrement impossible : Un type portant la même lettre existe déjà.";
        } else {
            $sql = "UPDATE ".TABLE_PREFIX."_type_area SET
            type_name='".protect_data_sql($type_name)."',
            order_display =";
            if (is_numeric($order_display))
              $sql= $sql .intval($order_display).",";
            else
              $sql= $sql ."0,";
            $sql = $sql . 'type_letter="'.$type_letter.'",';
            $sql = $sql . 'couleur="'.$couleur.'",';
            $sql = $sql . 'disponible="'.$disponible.'"';
            $sql = $sql . " WHERE id=$id_type";
            if (grr_sql_command($sql) < 0)
                {
                fatal_error(0, get_vocab('update_type_failed') . grr_sql_error());
                $ok = 'no';
                } else
                    $msg = get_vocab("message_records");
        }
    }
    else
    {
        // Test sur $type_letter
        $test = grr_sql_query1("select count(id) from ".TABLE_PREFIX."_type_area where type_letter='".$type_letter."'");

        if ($test > 0) {
            $msg = "Enregistrement impossible : Un type portant la même lettre existe déjà.";
        } else {
            $sql = "INSERT INTO ".TABLE_PREFIX."_type_area SET
            type_name='".protect_data_sql($type_name)."',
            order_display =";
            if (is_numeric($order_display))
              $sql= $sql .intval($order_display).",";
            else
              $sql= $sql ."0,";
            $sql = $sql . 'type_letter="'.$type_letter.'",';
            $sql = $sql . 'couleur="'.$couleur.'"';
            if (grr_sql_command($sql) < 0)
                {
                fatal_error(1, "<p>" . grr_sql_error());
                $ok = 'no';
                } else {
                	$id_type = grr_sql_insert_id();
                	$sql = "INSERT INTO ".TABLE_PREFIX."_j_etablissement_type_area SET
                	            id_etablissement='".protect_data_sql($id_etablissement)."',
                	            id_type_area= $id_type";
                	if (grr_sql_command($sql) < 0)
                	{
                		fatal_error(1, "<p>" . grr_sql_error());
                		$ok = 'no';
                	}else {
                		$id = grr_sql_insert_id("", "");
						$sql = "UPDATE  ".TABLE_PREFIX."_type_area 
								SET type_letter=id WHERE id = $id";
						grr_sql_command($sql);	
						$msg = get_vocab("message_records");
                	}
                }
        }

    }
}
    // Si pas de problème, retour à la page d'accueil après enregistrement
    if ((isset($_GET['change_done'])) and (!isset($ok))) {
        $_SESSION['displ_msg'] = 'yes';
        Header("Location: "."admin_type_etablissement.php?msg=".$msg);
        exit();
    }


# print the page header
    print_header("","","","",$type="with_session", $page="admin");
	include "admin_col_gauche.php";
	
	
    affiche_pop_up($msg,"admin");
    if ((isset($id_type)) and ($id_type>0)) {
        $res = grr_sql_query("SELECT * FROM ".TABLE_PREFIX."_type_area WHERE id=$id_type");
        if (! $res) fatal_error(0, get_vocab('message_records_error'));
        $row = grr_sql_row_keyed($res, 0);
        grr_sql_free($res);
        $change_type='modif';
        echo "<h2>".get_vocab("admin_type_modify_modify.php")."</h2>";
    } else {
        $row["id"] = '0';
        $row["type_name"] = '';
        $row["type_letter"] = '';
        $row["order_display"]  = 0;
        $row["disponible"]  = 2;
        $row["couleur"]  = '';
        echo "<h2>".get_vocab('admin_type_modify_create.php')."</h2>";
    }
    echo get_vocab('admin_type_explications')."<br /><br />";
    ?>
    <form action="admin_type_etablissement_modify.php" method='get'>
    <?php
    echo "<div><input type=\"hidden\" name=\"id_type\" value=\"".$id_type."\" /></div>\n";

    echo "<table border=\"1\">\n";
    echo "<tr>";
    echo "<td>".get_vocab("type_name").get_vocab("deux_points")."</td>\n";
    echo "<td><input type=\"text\" name=\"type_name\" value=\"".htmlspecialchars($row["type_name"])."\" size=\"20\" /></td>\n";
    echo "</tr><tr>\n";
   
	/*echo "<td>".get_vocab("type_num").get_vocab("deux_points")."</td>\n";
	echo "<td>";
    echo "<select name=\"type_letter\" size=\"1\">\n";
    echo "<option value=''>".get_vocab("choose")."</option>\n";
    $letter = "A";
    for ($i=1;$i<=100;$i++) {
       echo "<option value='".$letter."' ";
       if ($row['type_letter'] == $letter) echo " selected=\"selected\"";
       echo ">".$letter."</option>\n";
       $letter++;
    }
    echo "</select>";
    echo "</td>\n";*/
	
    echo "</tr><tr>\n";
    echo "<td>".get_vocab("type_order").get_vocab("deux_points")."</td>\n";
    echo "<td><input type=\"text\" name=\"order_display\" value=\"".htmlspecialchars($row["order_display"])."\" size=\"20\" /></td>\n";
    echo "</tr>";
    echo "<tr><td>".get_vocab("disponible_pour").get_vocab("deux_points")."</td>\n";
	echo "<td>"."<select name=\"disponible\" size=\"1\">\n";
	echo "<option value = '2' ";
	if ($row['disponible']=='2') {echo " selected=\"selected\"";}
	echo ">".get_vocab("all")."</option>\n";
	echo "<option value = '3' ";
	if ($row['disponible']=='3') {echo " selected=\"selected\"";}
	echo ">".get_vocab("gestionnaires_et_administrateurs")."</option>\n";
	echo "<option value = '5' ";
	if ($row['disponible']=='5') {echo " selected=\"selected\"";}
	echo ">".get_vocab("only_administrators")."</option>\n";
	echo "</select>";
    echo "</td></tr>";
   if ($row["couleur"]  != '') {
        echo "<tr>\n";
        echo "<td>".get_vocab("type_color").get_vocab("deux_points")."</td>\n";
        echo "<td bgcolor=\"".$tab_couleur[$row["couleur"]]."\">&nbsp;</td>";
        echo "</tr>";
    }
    echo "</table>\n";
    echo "<p>".get_vocab("type_color").get_vocab("deux_points")."</p>";
    echo "<table border=\"2\"><tr>\n";
    $nct = 0;
    foreach($tab_couleur as $key=>$value)
    {
      $checked = " ";
      if ($key == $row["couleur"])
          $checked = "checked=\"checked\"";
      if (++$nct > 4)
            {
                $nct = 1;
                echo "</tr><tr>";
            }
      echo "<td  style=\"background-color:".$tab_couleur[$key].";\"><input type=\"radio\" name=\"couleur\" value=\"".$key."\" ".$checked." />______________</td>";
    }
    echo "</tr></table>\n<br/>";
	

	echo "<input class=\"btn btn-primary\" type=\"submit\" name=\"change_type\" value=\"".get_vocab("save")."\" />\n";
	echo "<input class=\"btn btn-primary\" type=\"submit\" name=\"change_done\" value=\"".get_vocab("back")."\" />\n";
	echo "<input class=\"btn btn-primary\" type=\"submit\" name=\"change_room_and_back\" value=\"".get_vocab("save_and_back")."\" />";



?>
    </form>


</div>
</body>
</html>
