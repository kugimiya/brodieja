<center>
 <span class = 'links'>
  [<a href="index.php?st=umelight">ume-light</a>][<a href="index.php?st=umedark">ume-dark</a>][<a href="index.php?st=shirodark">shiro-dark</a>]
 </span> 
 <br>
 <span class = 'links'>
  <!-- [<a href="http://ume.mooo.com/">U-Me Group, Ltd.</a>] -->
<?php
	$str = '';
	for ($i=0; $i < count($services); $i++) {
		$str .= "[<a href = " . $services[$i][0] . ">" . $services[$i][1] . "</a>]";
	}
	echo $str;
?>
 </span> 
 <br>
 <!/center>
 <div class = "posting">
<?php 

	$rovnd = rand(1,3);
	if ($rovnd == 1) { $link = "1.png"; }
	if ($rovnd == 2) { $link = "2.png"; }
	if ($rovnd == 3) { $link = "1.gif"; } 

	echo "<img src=/pics/{$link}>";

?> 
 </div>
 <?php
	if ($index == true) {
		echo "<span class = 'titled'> Умечан </span> ";
	}
	else {
		echo "<a href='index.php'>Назад</a>";
	}
 ?>
</center>
<hr>
