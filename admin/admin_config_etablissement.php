<?php
/**
 * admin_config_etablissement.php
 * Interface permettant � l'administrateur la configuration de certains param�tres g�n�raux
 * Ce script fait partie de l'application GRR
 * Derni�re modification : $Date: 2010-05-07 21:26:44 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config.php,v 1.1 2010-05-07 21:26:44 grr Exp $
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
 * $Log: admin_config.php,v $
 * Revision 1.1  2010-05-07 21:26:44  grr
 * *** empty log message ***
 *
 * Revision 1.4  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 *
 */

include_once "../include/admin.inc.php";
$grr_script_name = "admin_config_etablissement.php";

$back = '';
if (isset($_SERVER['HTTP_REFERER'])) $back = htmlspecialchars($_SERVER['HTTP_REFERER']);

$_SESSION['chemin_retour'] = "admin_config_etablissement.php";

if(authGetUserLevel(getUserName(),-1,'etab') < 6)
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
    showAccessDenied($day, $month, $year, '',$back);
    exit();
}
$page_config = isset($_GET["page_config"]) ? $_GET["page_config"] : '1';

$config_global = false;

if ($page_config == 1) include_once "./admin_config_etablissement1.php";
else if ($page_config == 2) include_once "./admin_config_etablissement2.php";
else if ($page_config == 3) include_once "./admin_config_etablissement3.php";
else if ($page_config == 4) include_once "./admin_config_etablissement4.php";
else if ($page_config == 5) include_once "./admin_config_etablissement5.php"; // pour la configuration des jours/cycles
else die();

?>
</body>
</html>