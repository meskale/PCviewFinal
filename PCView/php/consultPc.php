<?php
session_start();
/**
 * affichage des details relatif a un PC dont l'id est transmis par GET
*/

/*
 *
* 	Methode classique DOM


require_once 'FlotteParser.class.php';
$flotte = new FlotteParser("Flotte.xml");


$xpath = $flotte->getXpath();


$query ='PC[@id="'.$_GET["id"].'"]/Config';
$entries = $xpath->query($query);


//$pc = $flotte->getPcById($_GET["id"]);

$pc = $entries->item(0);



$stockage 		= $pc->getElementsByTagName("Stockage");
$interfaces 	= $pc->getElementsByTagName("Interface");
$peripheriques  = $pc->getElementsByTagName("Peripherique");
$cpu 			= $pc->getElementsByTagName("CPU");
$ram 			= $pc->getElementsByTagName("RAM");
$cm 			= $pc->getElementsByTagName("CM");
$gpu 			= $pc->getElementsByTagName("GPU");
$bios			= $pc->getElementsByTagName("BIOS");


* Methode XPath

$stockage = $xpath->query('Stockages/Stockage',$pc);
$interfaces = $xpath->query('Interfaces/Interface',$pc);
$peripheriques = $xpath->query('Peripheriques/Peripherique',$pc);

*/
//
require_once './class/FlotteParser.class.php';
$flotte = new FlotteParser();
$flotte= $flotte->parse();
$flotte1 = $flotte->getFlotte();
$tmp1 =$_GET["id"];


foreach ($flotte1 as $i => $buf){
	$tmp = $buf->getName();
	if($tmp==$tmp1 )
	{
		$pc=$buf;
		break;
	}
}

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
			alt="logo en forme de pc IBM" />
		<header class="header">
			<h2>
				Consultation de
				<?php echo $_GET["id"]; ?>
			</h2>
			<a href="index.php">Retour au menu</a>
		</header>
	</div>
	<div id="content">
		<article id="hardware">
			<header class="subheader">Mat&eacute;riel </header>

				<strong>CPU : </strong>
				<ul>
				<?php
				/* DOM
				 $flotte->displayByName($pc->getName());
				$cpu = $cpu->item(0);
					
					
				echo $cpu->getAttribute("Nom")." ";
				echo $cpu->getElementsByTagName("NbCore")->item(0)->nodeValue."core@";
				echo $cpu->getElementsByTagName("Freq")->item(0)->nodeValue;
				echo $cpu->getElementsByTagName("Freq")->item(0)->getAttribute("Unite")." ";

				foreach ($cpu->getElementsByTagName("Cache") as $cache ){
					echo "cache ";
				echo $cache->getAttribute("Niveau")." : ";
				echo $cache->getElementsByTagName("Capacite")->item(0)->nodeValue." ";
				echo $cache->getElementsByTagName("Capacite")->item(0)->getAttribute("Unite")." ";
				}*/
				foreach($pc->getCPU() as $key => $cpuParam) {

								echo "<li>" . $key . " : " . $cpuParam . "</li>";

					}
							?>
			</ul>

				<strong>RAM : </strong>
				<?php
				/*
				 *
				$ram = $ram->item(0);
				echo $ram->getElementsByTagName("TYPE")->item(0)->nodeValue." ";
				echo $ram->getElementsByTagName("Capacite")->item(0)->nodeValue." ";
				echo $ram->getElementsByTagName("Capacite")->item(0)->getAttribute("Unite")."@";
				echo $ram->getElementsByTagName("Freq")->item(0)->nodeValue;
				echo $ram->getElementsByTagName("Freq")->item(0)->getAttribute("Unite");
					
				*/
				echo "<ul>" ;
				foreach($pc->getRAM() as $key => $ramParam) {
								echo "<li>" . $key . " : " . $ramParam . "</li>";
							}
							echo "</ul>";

							?>


				<strong>Carte m&egrave;re : </strong>

				<?php 
				/*
				 $cm = $cm->item(0);

				echo " Socket ";
				echo $cm->getElementsByTagName("Socket")->item(0)->nodeValue;
				echo " Chipset ";
				echo $cm->getElementsByTagName("Chipset")->item(0)->nodeValue;
				*/
				$buf=$pc->getCM();
				echo "<ul>" ;
				foreach($buf as $key => $cmParam) {
								echo "<li>" . $key . " : " . $cmParam . "</li>";
							}
							echo "</ul>";
							?>

				<strong>Carte graphique : </strong>

				<?php 
				/*
				 $gpu = $gpu->item(0);

				echo $gpu->getAttribute("Nom")." @";
				echo $gpu->getElementsByTagName("Freq")->item(0)->nodeValue;
				echo $gpu->getElementsByTagName("Freq")->item(0)->getAttribute("Unite");

				echo "  ";

				$gram = $gpu->getElementsByTagName("RAM")->item(0);

				echo $gram->getElementsByTagName("TYPE")->item(0)->nodeValue." ";
				echo $gram->getElementsByTagName("Capacite")->item(0)->nodeValue." ";
				echo $gram->getElementsByTagName("Capacite")->item(0)->getAttribute("Unite")."@";
				echo $gram->getElementsByTagName("Freq")->item(0)->nodeValue;
				echo $gram->getElementsByTagName("Freq")->item(0)->getAttribute("Unite")." ";

				echo $gpu->getElementsByTagName("Connectique")->item(0)->getAttribute("Nom");
				*/
				$buf=$pc->getGPU();
				echo "<ul>" ;
				foreach($buf as $key => $gpuParam) {
								echo "<li>" . $key . " : " . $gpuParam . "</li>";				
							}
							echo "</ul>";

							?>

				<strong>BIOS : </strong>
				<ul>
				<?php 
				/*
				 $bios = $bios->item(0);

				echo "Version : ";
				echo $bios->getAttribute("Version");
				echo "  Nom : ";
				echo $bios->getAttribute("Nom");
				*/
				$buf=$pc->getBIOS();

				foreach($buf as $key => $biosParam) {
					echo "<li>" . $key . " : " . $biosParam . "</li>";
				}
	
				?>
	</ul>

		</article>
		<article id="config">
			<header class="subheader"> D&eacute;tails g&eacute;n&eacute;ral </header>
			<table class="tab">
				<thead id='stockage'>
					<tr>
						<th scope="colgroup" colspan="4">Stockages</th>
					
					
					<tr>
						<th scope="col">Disque</th>
						<th scope="col">Taille</th>
						<th scope="col">Support</th>
						<th scope="col">Connectique</th>
					</tr>
				</thead>
				<tbody>
					<?php
					/*
					 foreach($stockage as $dd){
		echo "<tr><td>".$dd->getAttribute("Nom")."</td>";
					echo "<td>".$dd->nodeValue;
					echo $dd->getElementsByTagName("Capacite")->item(0)->getAttribute("Unite")."</td>";
					echo "<td>".$dd->getElementsByTagName("Support")->item(0)->getAttribute("Nom")."</td>";
					echo "<td>".$dd->getElementsByTagName("Connectique")->item(0)->getAttribute("Nom")."</td></tr>";
					}
					*/
					$buf=$pc->getStockages();

		 	 for($i=0;$i<count($buf);$i++){
				echo "<tr><td>".$buf[$i]['Nom']."</td>";
				echo "<td>".$buf[$i]['Capacite']."</td>";
				echo "<td>".$buf[$i]['Support']."</td>";
				echo "<td>".$buf[$i]['Connectique']."</td></tr>";
			}

			?>
				</tbody>
			</table>
			<div>
				<h3 class="subheader">Interfaces</h3>
				<ul>
					<?php
					/* DOM
					 foreach($interfaces as $in){

		echo "<li><ul><li><strong>Nom : </strong>".$in->getAttribute("Nom")."</li>";
					echo "<li><strong> Type : </strong>".$in->getElementsByTagName("TYPE")->item(0)->nodeValue."</li>" ;
					echo "<li><strong> MAC : </strong>".$in->getElementsByTagName("MAC")->item(0)->nodeValue."</li>";
					echo "<li><strong> IP : </strong>".$in->getElementsByTagName("IPV4")->item(0)->nodeValue."</li>";
					echo "<li><strong> Masque : </strong>".$in->getElementsByTagName("SUBNET")->item(0)->nodeValue."</li>";
					echo "<li><strong> Passerelle : </strong>".$in->getElementsByTagName("GATEWAY")->item(0)->nodeValue."</li></ul></li>";
					}*/
					$buf=$pc->getInterfaces();
					for($i=0;$i<count($buf);$i++){
					echo "<li><ul><li><strong>Nom : </strong>".$buf[$i]['Nom']."</li>";
					echo "<li><strong> Type : </strong>".$buf[$i]['Type']."</li>" ;
					echo "<li><strong> MAC : </strong>".$buf[$i]['MAC']."</li>";
					echo "<li><strong> IP : </strong>".$buf[$i]['IPV4']."</li>";
					echo "<li><strong> Masque : </strong>".$buf[$i]['SUBNET']."</li>";
					echo "<li><strong> Passerelle : </strong>".$buf[$i]['GATEWAY']."</li></ul></li>";
					}


					?>
				</ul>
			</div>
			<table class="tab">
				<thead>
					<tr>
						<th id='peripheriques' colspan="3" scope="col">Peripheriques</th>
					</tr>
					<tr>
						<th scope="col">Nom</th>
						<th scope="col">Connectique</th>
						<th scope="col">Type</th>
					</tr>
				</thead>
				<tbody>
					<?php
/*
					foreach($peripheriques as $pe){
		echo "<tr><td>".$pe->getAttribute("Nom")."</td>";
		echo "<td>".$pe->getElementsByTagName("Connectique")->item(0)->getAttribute("Nom")."</td>" ;
		echo "<td>".$pe->getElementsByTagName("TYPE")->item(0)->nodeValue."</td>";
		echo "</tr>";
}
*/				
					$buf = $pc->getPeripheriques();		
					for($i=0;$i<count($buf);$i++){
						echo "<tr><td>".$buf[$i]['Nom']."</td>";
						echo "<td>".$buf[$i]['Connectique']."</td>" ;
						echo "<td>".$buf[$i]['TYPE']."</td>";
						echo "</tr>";
					}
?>
				</tbody>
			</table>
			<table class="tab">
				<thead>
					<tr>
						<th id='softwares' colspan="3" scope="col">Softwares</th>
					</tr>
					<tr>
						<th scope="col">Nom</th>
						<th scope="col">Version</th>
						<th scope="col">Arch</th>
					</tr>
				</thead>
				<tbody>
					<?php
/*
					foreach($peripheriques as $pe){
		echo "<tr><td>".$pe->getAttribute("Nom")."</td>";
		echo "<td>".$pe->getElementsByTagName("Connectique")->item(0)->getAttribute("Nom")."</td>" ;
		echo "<td>".$pe->getElementsByTagName("TYPE")->item(0)->nodeValue."</td>";
		echo "</tr>";
}
*/	
					$buf = $pc->getSoftwares();
			
					for($i=0;$i<count($buf);$i++){
						echo "<tr><td>".$buf[$i]['Nom']."</td>";
						echo "<td>".$buf[$i]['Version']."</td>" ;
						echo "<td>".$buf[$i]['Arch']."</td>";
						echo "</tr>";
					}
?>
				</tbody>
			</table>
		</article>
	</div>
	<footer id="pdp">
		Site r&eacute;aliser par <a href="mailto:johannystrugala@free.fr">Johanny Strugala / Cedric Ergenschaeffter &#169;</a>
	</footer>
</body>
</html>

