<?php

if (isset($_POST['rankingdetail'])) {
	file_put_contents("/var/tokilx/openosn.temp", $_POST['rankingdetail']);
	echo "SERVER: Rank updated\n";
}

?>
