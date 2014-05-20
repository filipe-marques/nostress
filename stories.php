<?php
/* This (website) software includes code from: 
 *		Eagle PHP Bootstrap Copyright (C) 2013-2014 Filipe Marques - eagle.software3@gmail.com
 * 
 * This file is part of YouXuse - Nostress
 *
 * <YouXuse - web application to sell & buy componnents of tecnology>
 * Copyright (C) <2013 - 2014>  <Filipe Marques> <eagle.software3@gmail.com>
 *
 * YouXuse is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * YouXuse is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * For full reading of the license see the folder "license" 
 * 
 */
// DEVELOPMENT PURPOSES - DO NOT USE THIS IN PRODUCTION ENVIRONMENT
//error_reporting(E_ALL);
//ini_set('display_errors', true);
//ini_set('html_errors', false);
//--------------------------------------------------------
if(file_exists("init.php")){
	// requiring the init file
	require_once("init.php");
}else{
	die("Not found init.php file!");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="refresh" content="60"/>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
		<!-- Bootstrap core CSS -->
		<link href="<?php echo $files['css']; ?>" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="<?php echo $files['css-theme']; ?>" rel="stylesheet">
		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<div class="panel panel-default">
				<?php
					// selecting data in database table !
					if (isset($_SESSION['id'])){
						// EM SESSÃO
						$db->query("START TRANSACTION");
						if (($result = $db->query("SELECT * FROM nostress_desabafo ORDER BY id DESC"))){
							while($row = $result->fetch_object()){
								if (($result1 = $db->query("SELECT * FROM users WHERE id='" . $row->users_id1 . "'"))){
									while($row1 = $result1->fetch_object()){
										echo("<div class=\"panel-heading\">Nickname: " . $row1->nickname . " em " . $row->dat . "</div>");
										echo("<div class=\"panel-body\"><p>" . $row->text . "</p></div>");
									}
								}
							}
							$result1->free();
							$result->free();
							$db->query("COMMIT");
							$db->close();
						}
					}else{
						// LIMIT - SEM SESSÃO
						$db->query("START TRANSACTION");
						if (($result = $db->query("SELECT * FROM nostress_desabafo ORDER BY id DESC LIMIT 0,3"))){
							while($row = $result->fetch_object()){
								if (($result1 = $db->query("SELECT * FROM users WHERE id='" . $row->users_id1 . "'"))){
									while($row1 = $result1->fetch_object()){
										echo("<div class=\"panel-heading\">Nickname: " . $row1->nickname . " em " . $row->dat . "</div>");
										echo("<div class=\"panel-body\"><p>" . $row->text . "</p></div>");
									}
								}
							}
							$result1->free();
							$result->free();
							$db->query("COMMIT");
							$db->close();
						}
						echo("</div>");
						echo("<h2>Ver mais? Entra ou Regista-te para desabafares em segurança!</h2>");
					}
				?>
		</div>
	</body>
</html>
