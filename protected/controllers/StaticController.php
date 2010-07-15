<?php

class StaticController extends Controller {

    public $layout = 'application.views.layouts.static';
    public $needTitle;

    public function actionAbout() {
        $this->render('about');
    }

    public function actionContact() {
        $this->render('contact');
    }

    public function actionHelp() {
        $this->render('help');
    }

    public function actionOpenOSN() {
        $this->needTitle = false;
        $this->render('openosn');
    }

	public function actionPublicRankRisanSiKeji() {

		$rankDetail = json_decode(file_get_contents("/var/tokilx/openosn.temp") , true);

		//$dataProvider = new CArrayDataProvider($rankDetail['ranking']);

		$this->render('publicrank' , array(
			'ranking' => $rankDetail['ranking'],
			'problems' => $rankDetail['problems'],
			'timestamp' => $rankDetail['timestamp']
		));
	}

}