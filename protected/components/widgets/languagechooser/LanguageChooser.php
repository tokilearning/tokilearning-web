<?php

/**
 * LanguageChooser shows widget that display languages for user to choose.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @since 2011.11.04
 */
class LanguageChooser extends CWidget {
	/**
	 * Widget action prefix for the controller.
	 * @since 2011.11.04
	 */
	const WIDGET_ACTION_PREFIX = 'languagechooser.';

	/**
	 * Action names for this widget. 
	 * @since 2011.11.04
	 */
	/**
	 * Action name for the chooser action.
	 * @since 2011.11.04
	 */
	const CHANGE_ACTION_NAME = 'change';

	/**
	 * HTML attributes for the widget.
	 * @var array HTML options.
	 * @since 2011.11.04
	 */
	public $htmlOptions = array();

	/**
	 * @return array actions provided by this widget.
	 * @since 2011.11.04
	 */
	public static function actions() {
		return array(
		    self::CHANGE_ACTION_NAME => 'application.components.widgets.languagechooser.LanguageChooserAction',
		);
	}

	/**
	 * Initialize this widget.
	 * @since 2011.11.04
	 */
	public function init() {
		parent::init();
		if (isset($this->htmlOptions['id']))
			$this->id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $this->id;
	}

	/**
	 * Executes the widget.
	 * @since 2011.11.04
	 */
	public function run() {
		$languages = self::getSupportedLanguages();
		$currentLanguage = $languages[Yii::app()->language];
		$this->registerScripts();
		$this->render('index', array(
		    'id' => $this->id,
		    'languages' => $languages,
		    'currentLanguage' => $currentLanguage,
		));
	}

	/**
	 * TODO: Refactor the 'ajax/' string.
	 * @param string $action action name.
	 * @since 2011.11.04
	 * @return string submit route.
	 */
	public function getRoute($action) {
		return '/ajax/' . self::WIDGET_ACTION_PREFIX . $action;
	}

	/**
	 * Register scripts for this widget.
	 * @since 2011.11.04
	 */
	public function registerScripts() {
		Yii::app()->clientScript->registerCss(__CLASS__ . '-css', '
			#' . $this->id . ' .flag {
				display:block;
				width:100%;
			}
		');
		$changeUrl = $this->controller->createAbsoluteUrl($this->getRoute(self::CHANGE_ACTION_NAME));
		//data:{},
		Yii::app()->clientScript->registerScript(__CLASS__ . '-js', '
			jQuery(document).ready(function() {
				(function(menuLink, menuContainer) {
					jQuery(\'.flag-dd-cc\').width(menuContainer.outerWidth());

					var mouseOverMenu = false;

					menuLink.click(function(e) {
						e.preventDefault();
						menuContainer.toggleClass(\'active\');
					});

					menuContainer.mouseenter(function() {
						mouseOverMenu = true;
					})

					menuContainer.mouseleave(function() {
						mouseOverMenu = false;

						setTimeout(function() {
							if (!mouseOverMenu) {
								menuContainer.removeClass(\'active\');
							}

						}, 1000);

					});

				})(jQuery(\'.flag-dd-i\'), jQuery(\'.flag-dd-c\'));
				
				jQuery(\'#' . $this->id . ' .flag\').click(function(){
					var language = $(this).attr(\'language\');
					jQuery.ajax({
						type: \'POST\',
						url: \'' . $changeUrl . '\',
						data: {
							YII_CSRF_TOKEN:\'' . Yii::app()->request->csrfToken . '\',
							language : language
						},
						success: function (){
							location.reload();
						},
					});
				});
				
			});
		');
	}

	/**
	 *
	 * @return array supported languages.
	 * @since 2011.11.04
	 */
	public static function getSupportedLanguages() {
		return array(
		    'en' => array(
			'title' => Yii::t('translation', 'English'),
			'image' => Yii::app()->request->baseUrl . '/images/flag-uk.png',
		    ),
		    'id' => array(
			'title' => Yii::t('translation', 'Indonesian'),
			'image' => Yii::app()->request->baseUrl . '/images/flag-id.png',
		    ),
		);
	}

}