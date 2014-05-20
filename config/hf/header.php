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
}

?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<ul class="nav nav-tabs"><!--http://youxuse.com/-->
				<li><a href="http://youxuse.com/youxuse/index.php" title="YouXuse &trade; &copy; Buy & Sell - used parts of hardware">YouXuse</a></li>
				<li class="active"><a href="http://youxuse.com/nostress/index.php" title="A rede social do desabafo, desabafa para mundo, diz o que te preocupa e a comunidade ajuda!">NoStress</a>
				<?php
					$size = 20;
					$ddd = "identicon";
					$rr = "g";
					if (isset($_SESSION['prinome'])) {
						echo("<li><a href=\"user.php\" title=\"Definições da tua conta\">" . $sess->sexo() . " " . $_SESSION['prinome'] . " " . $_SESSION['ultnome'] . " " . $proc->get_gravatar($_SESSION['email'], $size, $ddd, $rr, true, '') . "</a>
							<li><a href=\"../logout.php\" title=\"Sair com segurança\">Logout</a>");
					}
				?>
				</li>
			</ul>
		</div>
		<br><br><br>
		<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav"><!-- pôr o domínio do site: http://www.youxuse.com -->
					<li><a href="index.php"><?php echo ("Início"); ?> <i class="icon-home icon-white"></i></a></li>
					<li><a href="tell.php"><?php echo ("Desabafar"); ?> <i class="icon-shopping-cart icon-white"></i></a></li>
					<li><a href="../youxuse/donate.php">Doar<i class="icon-heart icon-white"></i></a></li>
					<?php
						if (!isset($_SESSION['prinome'])) {
							echo("<li><a href=\"../index.php\">" . LABEL_HEADER_TEXT10 . " <i class=\"icon-plus-sign icon-white\"></i></a></li>");
							echo("<li><a href=\"../index.php\">" . LABEL_HEADER_TEXT11 . " <i class=\"icon-play icon-white\"></i></a></li>");
						}
					?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<div class="container">
	<br>
	<br>
	<br>
	<br>
	<center>
		<?php // tag like and share?>
		<iframe src="//www.facebook.com/plugins/like.php?href=https://www.facebook.com/youxuse&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px;" allowTransparency="true"></iframe>
		<?php // tag +1 button ?>
		<div class="g-plusone" data-size="tall" data-annotation="inline" data-width="300" data-href="https://plus.google.com/116778377892072300095"></div>
		<script type="text/javascript">
			(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
	</center>
	<br>
    <?php
    /*if (!$_SESSION['prinome']) {
        echo ("<h4><p class=\"text-left\">This is not your language, isn't ? <a href=\"#lang\">Change it</a> or <a href=\"signin.php\">sign up</a> !</p></h4>");
    }*/
    ?>
</div>
