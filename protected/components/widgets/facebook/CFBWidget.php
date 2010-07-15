<?php

abstract class CFBWidget extends CWidget {
    //TODO: Clean this
    const OG_TITLE = "og:title";
    const OG_TYPE = "og:type";
    const OG_URL = "og:url";
    const OG_IMAGE = "og:image";
    const OG_SITE_NAME = "og:site_name";
    const OG_DESCRIPTION = "og:description";
    const OG_EMAIL = "og:email";
    //
    const FB_ADMINS = "fb:admins";
    const FB_APP_ID = "fb:app_id";

    public $fb_app_id;
    public $fb_app_title;
    public $og_email;
    public $use_app_id = true;
    public $type = "article";

    public function init() {
        $this->fb_app_id = Yii::app()->params->facebook['app_id'];
        $this->fb_app_title = Yii::app()->name;
        $this->og_email = Yii::app()->params->adminEmail;
        $this->registerCoreFBMeta();
    }

    private function registerCoreFBMeta() {
        $app_id = $this->fb_app_id;
        if ($this->use_app_id) {
            Yii::app()->clientScript->registerScriptFile("http://connect.facebook.net/en_US/all.js#appId=$app_id&xfbml=1");
        } else {
            Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/en_US/all.js#xfbml=1');
        }
        $this->registerFBMeta(CFBWidget::OG_SITE_NAME, $this->fb_app_title);
        $this->registerFBMeta(CFBWidget::FB_APP_ID, $this->fb_app_id);
        $this->registerFBMeta(CFBWidget::OG_EMAIL, $this->og_email);
    }

    public function registerFBMeta($property, $content) {
        Yii::app()->clientScript->registerMetaTag($content, NULL, NULL, array('property' => $property));
    }

}