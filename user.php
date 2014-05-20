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

if (class_exists('Process') and class_exists('Sessions') and class_exists('Store')){
	$sess = new Sessions();
	$proc = new Process();
	$st = new Store();
}

if (session_start()){
	$proc->check_session_idiom();
}

$sess->nothing();
?>
<!DOCTYPE html>
<html class="full" lang="en">
<!-- The full page image background will only work if the html has the custom class set to it! Don't delete it! -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>
		<?php
			if (isset($_SESSION['prinome'])){
				echo($sess->sexo() . " " . $_SESSION['prinome'] . " " . $_SESSION['ultnome']); 
			}else{
				echo("NoStress - Desabafa, diz o que te preocupa e vais ver que te sentes muito melhor!");
			}
		?>
	</title>
	<!-- Bootstrap core CSS -->
	<link href="<?php echo $files['css']; ?>" rel="stylesheet">
	
	<!-- Custom CSS for the 'Full' Template -->
	<link href="<?php echo $files['css-theme']; ?>" rel="stylesheet">
</head>

<body>
	<?php require_once($files['header']); ?>
	<center>
	<div class="container">
		<!--<a type="button" href="user.php?nick=name" class="btn btn-success btn-lg">Nickname</a>-->
		
		<?php
			
			echo("<a type=\"button\" href=\"../youxuse/user.php?user=conta\" class=\"btn btn-primary btn-lg\">Mudar de palavra-passe</a>
					<a type=\"button\" href=\"user.php?user=nick\" class=\"btn btn-warning btn-lg\">Mudar de nickname</a>
					<a type=\"button\" href=\"tell.php\" class=\"btn btn-success btn-lg\">Desabafar</a>
					<a type=\"button\" href=\"../youxuse/donate.php\" class=\"btn btn-info btn-lg\">Doar</a>");
			
			$query = mysql_escape_string(htmlspecialchars(htmlentities(trim($_GET['user'])), ENT_QUOTES));
			
			if ($query === "nick"){
				if (isset($_POST['submit_mudar_nickname'])) {
					// inserting data in database table
					$nickname_novo = $db->real_escape_string(htmlspecialchars(trim($_POST['nickname_novo']), ENT_QUOTES));
					
					if (strlen($nickname_novo) < 10){
						echo("<br><br><br><div class=\"alert alert-danger\"><p class=\"lead\"><h2>Desculpa, mas o nickname tem de ser maior do que 10 caracteres! <a href=\"tell.php\">Tenta outra vez!</a></h2></p></div>");
						die();
					}
					
					// verificar se existem nicknames repetidos e apresentar o total
					$db->query("START TRANSACTION");
					if (($result = $db->query("SELECT * FROM users WHERE nickname='{$nickname_novo}'"))){
						if (($count = $result->num_rows)){
							echo("<br><br><br><div class=\"alert alert-danger\"><p class=\"lead\"><h2>Desculpa, este nickname já existe num total de " . $count . " nickname(s)! <a href=\"tell.php\">Tenta outra vez!</a></h2></p></div>");
							$result->free();
							$db->query("COMMIT");
							$db->close();
							die();
						}
					}  else {
						$db->query("COMMIT");
						$db->close();
					}
					
					$db->query("START TRANSACTION");
					if (!($db->query("UPDATE users SET nickname='{$nickname_novo}' WHERE id='" . $_SESSION['id'] . "'"))){
						$db->query("ROLLBACK");
						$db->close();
						echo("<br><br><br><div class=\"alert alert-danger\"><p class=\"lead\"><h2>Aconteceu um erro, não é tua culpa, mas por favor, repete!</h2></p></div>");
					}  else {
						$db->query("COMMIT");
						$db->close();
						echo("<br><br><br><div class=\"alert alert-success\"><p class=\"lead\"><h2>Mudaste com sucesso o teu nickname! Agora podes desabafar em segurança.</h2><br>Em 5 segundos a página será refrescada!</p></div>");
					}
					$_SESSION['nickname'] = $nickname_novo;
					echo("<meta http-equiv=\"refresh\" content=\"5\"/>");
				} else {
					echo ("<div class=\"row\">
							<div class=\"col-md-4\"></div>
							<div class=\"col-md-4\">
								<h3>
									<p class=\"text-center\">Mudar Nickname</p>
								</h3>");
					echo ("<form class=\"form-horizontal\" role=\"form\" action=\"user.php?user=nick\" method=\"POST\" name=\"form\" id=\"form\">
								<br>
								<input type=\"text\" class=\"form-control\" name=\"nickname_novo\" id=\"nickname_novo\" placeholder=\"novo nickname\" required>
								<br>
								<button class=\"btn btn-large btn-success btn-lg\" type=\"submit\" id=\"submit_mudar_nickname\" name=\"submit_mudar_nickname\">
									Mudar Nickname
									<span class=\"glyphicon glyphicon-user\"></span>
								</button>
							</form></div></div>");
				}
			}
		?>
	<?php require_once($files['footer']); ?>
	</div> <!-- /container -->
	</center>
	<!-- JavaScript -->
	<script src="<?php echo $files['jquery']; ?>"></script>
	<script src="<?php echo $files['js']; ?>"></script>
</body>
</html>
