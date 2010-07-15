<?php $this->setPageTitle("Konfigurasi Spesifik");?>
<?php $this->renderPartial('_menu');?>
<?php
$vHandler = $this->getContest()->getContestTypeHandler();

$vHandler->configurationWidget(array(
	'contest' => $this->getContest()
));

?>