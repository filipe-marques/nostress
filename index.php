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

if (!isset($_GET['lang'])) {
	if (!isset($_COOKIE['lang'])){
		require_once ("config/lang/pt.php");
	} else {
		//idiom_geoip();
		$proc->idiom_without_session($_COOKIE['lang']);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="60"/>
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
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="container">
				<h1>Desabafa com a comunidade, diz o que te preocupa!</h1>
					<p>Não te preocupes, aqui existe privacidade, podes dizer o que quiseres, insultar alguém que te chateou, alguma situação que não gostaste, "descarregar o saco", etc... e depois vais ver que te sentes muito melhor!
						<br>
						Por outro lado se precisares de ajuda, a comunidade está aqui para ajudar!
					<?php
						$db->query("START TRANSACTION");
						if (($result = $db->query("SELECT * FROM nostress_desabafo"))){ // the COUNT(*) function doesn't work with INNODB
							if (($count = $result->num_rows)){
								echo("<br>Existem cerca de: " . $count . " desabafos! Desabafa em segurança, <a href=\"tell.php\">aqui</a>!");
								$db->query("COMMIT");
								$result->free();
							}
							$db->close();
						}
					?>
					</p>
				<p><a class="btn btn-info btn-lg" href="tell.php" role="button">Quero desabafar &raquo;</a></p>
			</div>
		</div>
		<div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-4">
				<h2>Privacidade garantida</h2>
				<p>Através de um nickname (alcunha), estás protegido (desde que não digas a tua alcunha a ninguém) contra as pessoas que não gostem dos teus comentários!
					<br>Não poderás usar o teu nome ou derivados, porque as pessoas poderão saber que és tu, se o fizeres estás por tua conta e risco!</p>
				<p><a class="btn btn-info btn-lg" href="tell.php" role="button">Sabe mais &raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>"Só quero guardar boas recordações da vida!"</h2>
				<p>Também eu, por isso, existe este website para dizeres o que te preocupa, o que te enerva, em suma descarregares!</p>
				<p><a class="btn btn-info btn-lg" href="tell.php" role="button">Sabe mais &raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>Poupa dinheiro em psicólogo</h2>
				<p>Desabafar é muito bom para saúde mental, aqui neste website é gratuito e comódo!
					<br>Se sentiste que este website é fundamental para ti, por favor faz uma <a href="../youxuse/donate.php">doação</a>!
				</p>
				<p><a class="btn btn-info btn-lg" href="tell.php" role="button">Sabe mais &raquo;</a></p>
			</div>
		</div>
		<?php require_once($files['footer']); ?>
		</div> <!-- /container -->
		<!-- Bootstrap core JavaScript
		================================================== -->
		<script src="<?php echo $files['jquery']; ?>"></script>
		<script src="<?php echo $files['js']; ?>"></script>
	</body>
</html>
