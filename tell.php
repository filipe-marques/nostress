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

if (class_exists('Process') and class_exists('Sessions')){
	$sess = new Sessions();
	$proc = new Process();
	//$st = new Store();
}

if (session_start()){
	$proc->check_session_idiom();
}

if (!isset($_GET['lang'])) {
	if (!isset($_COOKIE['lang'])){
		require_once ("config/lang/pt.php");
	} else {
		//idiom_geoip();
		$proc->idiom_without_session($_COOKIE['lang']);
	}
}

if (isset($_POST['submit_nickname'])){
	// inserting data in database table
	$nickname = $db->real_escape_string(htmlspecialchars(trim($_POST['nickname']), ENT_QUOTES));
	
	if (strlen($nickname) < 10){
		echo("<br><br><br><div class=\"alert alert-danger\"><p class=\"lead\"><h2>Desculpa, mas o nickname tem de ser maior do que 10 caracteres! <a href=\"tell.php\">Tenta outra vez!</a></h2></p></div>");
		die();
	}
	
	// verificar se existem nicknames repetidos e apresentar o total
	$db->query("START TRANSACTION");
	if (($result = $db->query("SELECT * FROM users WHERE nickname='{$nickname}'"))){
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
	if (!($db->query("UPDATE users SET nickname='{$nickname}' WHERE id='" . $_SESSION['id'] . "'"))){
		$db->query("ROLLBACK");
		$db->close();
		echo("<br><br><br><div class=\"alert alert-danger\"><p class=\"lead\"><h2>Aconteceu um erro, não é tua culpa, mas por favor, repete!</h2></p></div>");
	}  else {
		$db->query("COMMIT");
		$db->close();
		echo("<br><br><br><div class=\"alert alert-success\"><p class=\"lead\"><h2>Registas-te com sucesso o teu nickname! Agora podes desabafar em segurança.</h2><br>Em 5 segundos a página será refrescada!</p></div>");
	}
	$_SESSION['nickname'] = $nickname;
	echo("<meta http-equiv=\"refresh\" content=\"5\"/>");
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
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
	<?php require_once($files['header']); ?>
		<div class="container">
		<?php
		// Inserir desabafo
		if (isset($_POST['submit_desabafo'])){
			// inserting data in database table
			$desabafa = $db->real_escape_string(htmlspecialchars(trim($_POST['desabafa']), ENT_QUOTES));
			$date = date('d-m-Y');
			
			$db->query("START TRANSACTION");
			if (!($insert = $db->query("INSERT INTO nostress_desabafo(users_id1,text,dat) VALUES ('" . $_SESSION['id'] . "','{$desabafa}','{$date}')"))){
				$db->query("ROLLBACK");
				$db->close();
				echo("<br><br><br><div class=\"alert alert-danger\"><p class=\"lead\"><h2>Aconteceu um erro, não é tua culpa, mas por favor, repete!</h2></p></div>");
			} else {
				$db->query("COMMIT");
				$db->close();
				echo("<br><br><br><div class=\"alert alert-success\"><p class=\"lead\"><h2>Já te sentes muito melhor!</h2></p></div>");
				echo("<meta http-equiv=\"refresh\" content=\"2\"/>");
			}
		}
		
			if (isset($_SESSION['prinome'])){
				if (empty($_SESSION['nickname'])){
					echo("<form class=\"form-horizontal\" role=\"form\" action=\"tell.php\" method=\"POST\" name=\"form\" id=\"form\">
							<h2>Ainda não tens nickname (alcunha), para poderes desabafar em segurança!</h2>
							<input type=\"text\" class=\"form-control\" name=\"nickname\" id=\"nickname\" placeholder=\"Escreve aqui o teu nickname (na tua página de utilizador em NoStress, poderás mudar o teu nickname)\" required>
							<br>
							<p class=\"text-center\">
								<button class=\"btn btn-large btn-success btn-lg\" type=\"submit\" id=\"submit_nickname\" name=\"submit_nickname\">
									Registar Nickname
									<span class=\"glyphicon glyphicon-user\"></span>
								</button>
							</p>
							</form>");
				}else{
					echo("<form class=\"form-horizontal\" role=\"form\" action=\"tell.php\" method=\"POST\" name=\"form\" id=\"form\">
							<textarea maxlength=\"500\" lengthcut=\"true\" class=\"form-control\" rows=\"3\" id=\"desabafa\" name=\"desabafa\" placeholder=\"Desabafa - Deita cá pra fora!\" required></textarea>
							<br>
							<p class=\"text-center\">
								<button class=\"btn btn-large btn-success btn-lg\" type=\"submit\" id=\"submit_desabafo\" name=\"submit_desabafo\">
									Desabafar 
									<span class=\"glyphicon glyphicon-comment\"></span>
								</button>
							</p>
							</form>");
				}
			}else{
				echo("<h1>Estás chateado com alguma coisa? Deita cá pra fora!<br>Vais ver que te sentes melhor!</h1><br><h2><a href=\"../index.php\">Entra ou Regista-te</a> para desabafares em segurança!</h2>");
			}
		?>
		<div class="panel panel-info"><h3>Desabafos dos utilizadores:</h3>
			<iframe src="stories.php" scrolling="yes" frameborder="0" style="border:0; overflow:hidden; width:1138px; height:500px;" allowTransparency="true"></iframe>
		</div>
		<?php require_once($files['footer']); ?>
		</div> <!-- /container -->
		<!-- Bootstrap core JavaScript
		================================================== -->
		<script src="<?php echo $files['jquery']; ?>"></script>
		<script src="<?php echo $files['js']; ?>"></script>
		<script type="text/javascript" src="<?php echo $files['counter_character']; ?>"></script>
	</body>
</html>
