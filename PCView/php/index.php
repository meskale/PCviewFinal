<?php
//session_start();

//require_once 'FlotteParserOld.class.php';
//$flotte = new FlotteParser("Flotte.xml");
//$pcs = $flotte->getPcList($_SESSION["filtre"]);
//$nbpc =$pcs->length;

//declaration / instanciation / initialisation
require 'class/FlotteParser.class.php';
$flotte = new FlotteParser();
$flotte= $flotte->parse();



//Mise en place de filtre a l'affichage
if(isset($_POST['filtre']))
	$_SESSION['filtre']=$_POST['filtre'];

if(isset($_POST['typeFiltre']))
	$_SESSION['typeFiltre']=$_POST['typeFiltre'];

if(isset($_SESSION['filtre']) && $_SESSION['filtre']!=null)
{
	$pcs=$flotte->getFilteredPC($_SESSION['filtre'],$_SESSION['typeFiltre']);
	
}else 
{
	$pcs = $flotte->getFlotte();
}


$nbpc = count($pcs);

//On veut quel page
if(isset($_GET["page"]))
	$page = ($_GET["page"]!="")?$_GET["page"]:1;
else
	$page= 1;

//On desire changer le nombre d'�l�ment par page ?
if(isset($_POST['nbpcpp']) )
{
	$_SESSION['nbpcpp']=$_POST['nbpcpp'];
	$nbpcpp = $_SESSION['nbpcpp'];
}
else {
	if(isset($_SESSION["nbpcpp"])){
		$nbpcpp = $_SESSION['nbpcpp'];
	}else{
		$nbpcpp = 5;
	}
}

$nbpg = ceil($nbpc/$nbpcpp); //nombre de page

?>

<!DOCTYPE html >
<html lang="fr">
<title>PC View</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
</head>
<body>
	<div id="logo">
		<img src="img/logo1.png" style="position: absolute;"
			alt="logo en forme de pc" />
		<header class="header">
			<h2>Bienvenue sur l'interface de consultation des PCs</h2>
			  <form id='formFiltre' action="index.php" method="post">
				<label for="filtre">Recherche :</label><input type="text"
					id="filtre" name="filtre" size="20"
					value="<?php echo $_SESSION['filtre'];?>" />
					<label for="typeFiltre">Que rechercher ?</label>
					<select id="typeFiltre" name="typeFiltre" >
						<option value="OS" >systeme d'exploitation</option>
						<option value="Nom" selected="selected" >nom du pc</option>
						<option value="IPv4" >adresse ip</option>
						<option value="X" >Total</option>
					</select>
					 <input type="submit"	value="chercher " />
			</form>
		</header>
	</div>

	<div id="content">
		<article>
			<header>Liste des PCs</header>
			<nav id="listPc">
				<ul>
					<?php 
					$startIndex = 	($page-1)*$nbpcpp ;
					$endIndex = $page*$nbpcpp;
					//retrait des it�rations superflue, pour les pages partiels
					$endIndex -= (($endIndex-$nbpc)>0)?($endIndex-$nbpc):0;

					/*	Sans class
					 * for($i=$startIndex; $i< $endIndex ;$i++){
    	echo "<li><a href='consultPc.php?id=";
					echo $pcs->item($i)->getAttribute("id")."'><strong>";
					echo $pcs->item($i)->getElementsByTagName("Nom")->item(0)->nodeValue;
					echo "</strong></a></li>";
					}
					*/

					for($i=$startIndex; $i< $endIndex ;$i++){
						$pc = (object)$pcs[$i];
						echo "<li><a href='consultPc.php?id=";
						echo urlencode($pc->getName())."'><strong>";
						echo $pc->getName();
						echo "</strong></a></li>";
					}

					?>
				</ul>
			</nav>
			<footer>
				<ul>
					<?php 
					for($j=0;$j<$nbpg;$j++){
						echo "<li><a href=\"index.php?page=".($j+1)."\" >".($j+1)."</a></li>";
						}
						?>
				</ul>
				<form id="param" name="param" action='index.php' method="post">
					<label for="nbpcpp">Nombre de pc par page</label> <select
						id="nbpcpp" name="nbpcpp"
						onchange="document.forms['param'].submit()">
						<option value="3"
						<?php echo ($nbpcpp==3)?"selected='selected'":""; ?>>3</option>
						<option value="5"
						<?php echo ($nbpcpp==5)?"selected='selected'":""; ?>>5</option>
						<option value="10"
						<?php echo ($nbpcpp==10)?"selected='selected'":""; ?>>10</option>
						<option value="20"
						<?php echo ($nbpcpp==20)?"selected='selected'":""; ?>>20</option>
					</select>
					<button id="bs" type="submit">Appliquer</button>
				</form>

			</footer>

		</article>
	</div>
	<footer id="pdp">
		Site r&eacute;aliser par <a href="mailto:johannystrugala@free.fr">Johanny
			Strugala /Cedric Ergenschaeffter &#169;</a>
	</footer>
</body>
</html>

