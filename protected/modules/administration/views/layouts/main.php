<?php
/* @var $this Controller */
define('BASE_URL', $this->module->getAssetsUrl());
define('ADMIN_THEME_CSS', BASE_URL . '/css');
define('ADMIN_THEME_JS', BASE_URL . '/js');
define('ADMIN_THEME_IMAGES', BASE_URL . '/img');
?>
<!DOCTYPE html>
<html lang="en">
        <head>
                <!--
                        Charisma v1.0.0
        
                        Copyright 2012 Muhammad Usman
                        Licensed under the Apache License v2.0
                        http://www.apache.org/licenses/LICENSE-2.0
        
                        http://usman.it
                        http://twitter.com/halalit_usman
                -->
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="language" content="<?php echo Yii::app()->language; ?>" />
                <title><?php echo CHtml::encode($this->pageTitle); ?></title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="description" content="">
                <meta name="author" content="">
                <!-- The styles -->
                <link id="bs-css" href="<?php echo ADMIN_THEME_CSS; ?>/bootstrap-style.css" rel="stylesheet">
                <style type="text/css">
                        body {
                                padding-bottom: 40px;
                        }
                        .sidebar-nav {
                                padding: 9px 0;
                        }
                </style>
                <link href="<?php echo ADMIN_THEME_CSS; ?>/bootstrap-responsive.css" rel="stylesheet">
                <link href="<?php echo ADMIN_THEME_CSS; ?>/charisma-app.css" rel="stylesheet">
                <link href="<?php echo ADMIN_THEME_CSS; ?>/jquery-ui-1.8.21.custom.css" rel="stylesheet">
                <link href='<?php echo ADMIN_THEME_CSS; ?>/fullcalendar.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/fullcalendar.print.css' rel='stylesheet'  media='print'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/chosen.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/uniform.default.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/colorbox.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/jquery.cleditor.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/jquery.noty.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/noty_theme_default.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/elfinder.min.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/elfinder.theme.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/jquery.iphone.toggle.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/opa-icons.css' rel='stylesheet'>
                <link href='<?php echo ADMIN_THEME_CSS; ?>/uploadify.css' rel='stylesheet'>
                <script src="<?php echo ADMIN_THEME_JS; ?>/modernizr.custom.js"></script>

                <!--         The HTML5 shim, for IE6-8 support of HTML5 elements -->
                <!--[if lt IE 9]>
                    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                <![endif]-->

                <!-- The fav icon -->
                <link rel="shortcut icon" href="<?php echo ADMIN_THEME_IMAGES; ?>/favicon.ico">

        </head>

        <body>
                <div class="navbar">
                        <div class="navbar-inner">
                                <div class="container-fluid">
                                        <a data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse" data-toggle="collapse" class="btn btn-navbar">
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                        </a>
                                        <a href="index.html" class="brand"> <span></span></a>

                                        <!-- user dropdown starts -->
                                        <div class="btn-group pull-right">
                                                <a href="#" data-toggle="dropdown" class="btn dropdown-toggle">
                                                        <i class="icon-user"></i><span class="hidden-phone"> admin</span>
                                                        <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                        <li><a href="#">Profile</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="login.html">Logout</a></li>
                                                </ul>
                                        </div>
                                        <!-- user dropdown ends -->

                                        <div class="top-nav nav-collapse">
                                                <ul class="nav">
                                                        <li><a href="#">Visit Site</a></li>
                                                        <li>
                                                                <form class="navbar-search pull-left">
                                                                        <input type="text" name="query" class="search-query span2" placeholder="Search">
                                                                </form>
                                                        </li>
                                                </ul>
                                        </div><!--/.nav-collapse -->
                                </div>
                        </div>
                </div>
                <div class="container-fluid">
                        <div class="row-fluid">
                                <?php echo $content; ?>
                        </div>
                        <hr>
                        <footer>
                                <p class="pull-left">&copy; <a href="" target="_blank"></a> 2012</p>
                                <p class="pull-right"><?php echo Yii::powered(); ?></p>
                        </footer>

                </div><!--/.fluid-container-->

                <!-- external javascript
                ================================================== -->
                <!-- Placed at the end of the document so the pages load faster -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery-1.7.2.min.js"></script>
                <!-- jQuery UI -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery-ui-1.8.21.custom.min.js"></script>
                <!-- transition / effect library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-transition.js"></script>
                <!-- alert enhancer library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-alert.js"></script>
                <!-- modal / dialog library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-modal.js"></script>
                <!-- scrolspy library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-scrollspy.js"></script>
                <!-- library for creating tabs -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-tab.js"></script>
                <!-- library for advanced tooltip -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-tooltip.js"></script>
                <!-- popover effect library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-popover.js"></script>
                <!-- button enhancer library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-button.js"></script>
                <!-- carousel slideshow library (optional, not used in demo) -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-carousel.js"></script>
                <!-- autocomplete library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-typeahead.js"></script>
                <!-- tour library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/bootstrap-tour.js"></script>
                <!-- library for cookie management -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.cookie.js"></script>
                <!-- calander plugin -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/fullcalendar.min.js"></script>
                <!-- data table plugin -->
                <!-- <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.dataTables.min.js"></script> -->

                <!-- chart libraries start -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/excanvas.js"></script>
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.flot.min.js"></script>
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.flot.pie.min.js"></script>
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.flot.stack.js"></script>
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.flot.resize.min.js"></script>
                <!-- chart libraries end -->

                <!-- select or dropdown enhancer -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.chosen.min.js"></script>
                <!-- checkbox, radio, and file input styler -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.uniform.min.js"></script>
                <!-- plugin for gallery image view -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.colorbox.min.js"></script>
                <!-- rich text editor library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.cleditor.min.js"></script>
                <!-- notification plugin -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.noty.js"></script>
                <!-- file manager library -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.elfinder.min.js"></script>
                <!-- star rating plugin -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.raty.min.js"></script>
                <!-- for iOS style toggle switch -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.iphone.toggle.js"></script>
                <!-- autogrowing textarea plugin -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.autogrow-textarea.js"></script>
                <!-- multiple file upload plugin -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.uploadify-3.1.min.js"></script>
                <!-- history.js for cross-browser state change on ajax -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/jquery.history.js"></script>
                <!-- application script for Charisma demo -->
                <script src="<?php echo ADMIN_THEME_JS; ?>/charisma.js"></script>
        </body>
</html>