
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
        <head>
                <meta charset="utf-8">

                <!-- DNS prefetch -->
                <link rel=dns-prefetch href="//fonts.googleapis.com">

                <!-- Use the .htaccess and remove these lines to avoid edge case issues.
                     More info: h5bp.com/b/378 -->
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

                <title><?php echo $this->pageTitle; ?></title>
                <meta name="description" content="">
                <meta name="author" content="">

                <!-- Mobile viewport optimized: j.mp/bplateviewport -->
                <meta name="viewport" content="width=device-width,initial-scale=1">

                <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

                <!-- CSS: implied media=all -->
                <!-- CSS concatenated and minified via ant build script-->
                <?php $this->module->registerCssFile('style.css'); ?>
                <?php $this->module->registerCssFile('960.fluid.css'); ?>
                <?php $this->module->registerCssFile('main.css'); ?>
                <?php $this->module->registerCssFile('buttons.css'); ?>
                <?php $this->module->registerCssFile('lists.css'); ?>
                <?php $this->module->registerCssFile('icons.css'); ?>
                <?php $this->module->registerCssFile('notifications.css'); ?>
                <?php $this->module->registerCssFile('typography.css'); ?>
                <?php $this->module->registerCssFile('forms.css'); ?>
                <?php $this->module->registerCssFile('tables.css'); ?>
                <?php $this->module->registerCssFile('charts.css'); ?>
                <?php $this->module->registerCssFile('jquery-ui-1.8.15.custom.css'); ?>

                <!-- end CSS-->

                <!-- Fonts -->
                <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
                <!-- end Fonts-->

                <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

                <!-- All JavaScript at the bottom, except for Modernizr / Respond.
                     Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
                     For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
                <?php $this->module->registerScriptFile('libs/modernizr-2.0.6.min.js', CClientScript::POS_HEAD); ?>
        </head>

        <body id="top">

                <!-- Begin of #container -->
                <div id="container">
                        <!-- Begin of #header -->
                        <div id="header-surround"><header id="header">

                                        <!-- Place your logo here -->
                                        <img src="<?php echo $this->getAssetsUrl(); ?>/img/logo.png" alt="Grape" class="logo">

                                        <!-- Divider between info-button and the toolbar-icons -->
                                        <div class="divider-header divider-vertical"></div>

                                        <!-- Info-Button -->
                                        <a href="javascript:void(0);" onclick="$('#info-dialog').dialog({ modal: true });"><span class="btn-info"></span></a>

                                        <!-- Modal Box Content -->
                                        <div id="info-dialog" title="About" style="display: none;">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                        </div> <!--! end of #info-dialog -->

                                        <!-- Begin from Toolbox -->
                                        <ul class="toolbox-header">
                                                <!-- First entry -->
                                                <li>
                                                        <a rel="tooltip" title="Create a User" class="toolbox-action" href="javascript:void(0);"><span class="i-24-user-business"></span></a>
                                                        <div class="toolbox-content">

                                                                <!-- Box -->
                                                                <div class="block-border">
                                                                        <div class="block-header small">
                                                                                <h1>Create a User</h1>
                                                                        </div>
                                                                        <form id="create-user-form" class="block-content form" action="" method="post">
                                                                                <div class="_100">
                                                                                        <p><label for="username">Username</label><input id="username" name="username" class="required" type="text" value="" /></p>
                                                                                </div>
                                                                                <div class="_50">
                                                                                        <p class="no-top-margin"><label for="firstname">Firstname</label><input id="firstname" name="firstname" class="required" type="text" value="" /></p>
                                                                                </div>
                                                                                <div class="_50">
                                                                                        <p class="no-top-margin"><label for="lastname">Lastname</label><input id="lastname" name="lastname" class="required" type="text" value="" /></p>
                                                                                </div>
                                                                                <div class="clear"></div>

                                                                                <!-- Buttons with actionbar  -->
                                                                                <div class="block-actions">
                                                                                        <ul class="actions-left">
                                                                                                <li><a class="close-toolbox button red" id="reset" href="javascript:void(0);">Cancel</a></li>
                                                                                        </ul>
                                                                                        <ul class="actions-right">
                                                                                                <li><input type="submit" class="button" value="Create the User"></li>
                                                                                        </ul>
                                                                                </div> <!--! end of #block-actions -->
                                                                        </form>
                                                                </div> <!--! end of box -->

                                                        </div>
                                                </li> <!--! end of first entry -->

                                                <!-- Second entry -->
                                                <li>
                                                        <a rel="tooltip" title="Write a Message" class="toolbox-action" href="javascript:void(0);"><span class="i-24-inbox-document"></span></a>
                                                        <div class="toolbox-content">

                                                                <!-- Box -->
                                                                <div class="block-border">
                                                                        <div class="block-header small">
                                                                                <h1>Write a Message</h1>
                                                                        </div>
                                                                        <form id="write-message-form" class="block-content form" action="" method="post">							
                                                                                <p class="inline-mini-label">
                                                                                        <label for="recipient">Recipient</label>
                                                                                        <input type="text" name="recipient" class="required">
                                                                                </p>
                                                                                <p class="inline-mini-label">
                                                                                        <label for="subject">Subject</label>
                                                                                        <input type="text" name="subject">
                                                                                </p>
                                                                                <div class="_100">
                                                                                        <p class="no-top-margin"><label for="message">Message</label><textarea id="message" name="message" class="required" rows="5" cols="40"></textarea></p>
                                                                                </div>

                                                                                <div class="clear"></div>

                                                                                <!-- Buttons with actionbar  -->
                                                                                <div class="block-actions">
                                                                                        <ul class="actions-left">
                                                                                                <li><a class="close-toolbox button red" id="reset2" href="javascript:void(0);">Cancel</a></li>
                                                                                        </ul>
                                                                                        <ul class="actions-right">
                                                                                                <li><input type="submit" class="button" value="Send Message"></li>
                                                                                        </ul>
                                                                                </div> <!--! end of #block-actions -->
                                                                        </form>
                                                                </div> <!--! end of box -->

                                                        </div>
                                                </li> <!--! end of second entry -->

                                                <!-- Third entry -->
                                                <li>
                                                        <a rel="tooltip" title="Create a Folder" class="toolbox-action" href="javascript:void(0);"><span class="i-24-folder-horizontal-open"></span></a>
                                                        <div class="toolbox-content">

                                                                <!-- Box -->
                                                                <div class="block-border">
                                                                        <div class="block-header small">
                                                                                <h1>Create a Folder</h1>
                                                                        </div>
                                                                        <form id="create-folder-form" class="block-content form" action="" method="post">
                                                                                <p class="inline-mini-label">
                                                                                        <label for="folder-name">Name</label>
                                                                                        <input type="text" name="folder-name" class="required">
                                                                                </p>

                                                                                <!-- Buttons with actionbar  -->
                                                                                <div class="block-actions">
                                                                                        <ul class="actions-left">
                                                                                                <li><a class="close-toolbox button red" id="reset3" href="javascript:void(0);">Cancel</a></li>
                                                                                        </ul>
                                                                                        <ul class="actions-right">
                                                                                                <li><input type="submit" class="button" value="Create Folder"></li>
                                                                                        </ul>
                                                                                </div> <!--! end of #block-actions -->
                                                                        </form>
                                                                </div> <!--! end of box -->

                                                        </div>
                                                </li> <!--! end of third entry -->
                                        </ul>

                                        <!-- Begin of #user-info -->
                                        <div id="user-info">
                                                <p>
                                                        <span class="messages">Hello <a href="javascript:void(0);">Administrator</a> ( <a href="javascript:void(0);"><img src="<?php echo $this->getAssetsUrl(); ?>/img/icons/packs/fugue/16x16/mail.png" alt="Messages"> 3 new messages</a> )</span>
                                                        <a href="javascript:void(0)" class="toolbox-action button">Settings</a> <a href="javascript:void(0);" class="button red">Logout</a>
                                                </p>
                                        </div> <!--! end of #user-info -->

                                </header></div> <!--! end of #header -->

                        <div class="fix-shadow-bottom-height"></div>

                        <!-- Begin of Sidebar -->
                        <aside id="sidebar">

                                <!-- Search -->
                                <div id="search-bar">
                                        <form id="search-form" name="search-form" action="search.php" method="post">
                                                <input type="text" id="query" name="query" value="" autocomplete="off" placeholder="Search">
                                        </form>
                                </div> <!--! end of #search-bar -->

                                <!-- Begin of #login-details -->
                                <section id="login-details">
                                        <img class="img-left framed" src="<?php echo $this->getAssetsUrl(); ?>/img/misc/avatar_small.png" alt="Hello Admin">
                                        <h3>Logged in as</h3>
                                        <h2><a class="user-button" href="javascript:void(0);">Administrator&nbsp;<span class="arrow-link-down"></span></a></h2>
                                        <?php
                                        $this->widget('zii.widgets.CMenu', array(
                                                'items' => array(
                                                        array('label' => Yii::t('menu', 'Profile'), 'url' => array('dashboard/index')),
                                                        array('label' => Yii::t('menu', 'Settings'), 'url' => array('users/index')),
                                                        array('label' => Yii::t('menu', 'Messages'), 'url' => array('problems/index')),
                                                        array('label' => Yii::t('menu', 'Logout'), 'url' => array('problems/index')),
                                                ),
                                                'htmlOptions' => array(
                                                        'class' => 'dropdown-username-menu'
                                                )
                                        ));
                                        ?>
                                        <div class="clearfix"></div>
                                </section> <!--! end of #login-details -->

                                <!-- Begin of Navigation -->
                                <nav id="nav">
                                        <?php
                                        $this->widget('zii.widgets.CMenu', array(
                                                'items' => array(
                                                        array('label' => Yii::t('menu', 'Dashboard'), 'url' => array('dashboard/index')),
                                                        array('label' => Yii::t('menu', 'Users'), 'url' => array('users/index')),
                                                        array('label' => Yii::t('menu', 'Problems'), 'url' => array('problems/index')),
                                                ),
                                                'htmlOptions' => array(
                                                        'class' => 'menu collapsible shadow-bottom'
                                                )
                                        ));
                                        ?>
                                </nav> <!--! end of #nav -->

                        </aside> <!--! end of #sidebar -->

                        <!-- Begin of #main -->
                        <div id="main" role="main">

                                <!-- Begin of titlebar/breadcrumbs -->
                                <div id="title-bar">
                                        <?php
                                        //TODO: Generate Bread Crumb;
                                        $items = array(
                                                array('label' => CHtml::tag('span', array('id' => 'bc-home'), ''), 'url' => array('dashboard/index')),
                                        );

                                        $this->widget('zii.widgets.CMenu', array(
                                                'encodeLabel' => false,
                                                'id' => 'breadcrumbs',
                                                'items' => $items,
                                        ));
                                        ?>

                                </div> <!--! end of #title-bar -->

                                <div class="shadow-bottom shadow-titlebar"></div>

                                <!-- Begin of #main-content -->
                                <div id="main-content" class="container_12">
                                        <?php echo $content; ?>
                                        <div class="clear height-fix"></div>
                                </div> <!--! end of #main-content -->
                        </div> <!--! end of #main -->


                        <footer id="footer"><div class="container_12">
                                        <div class="grid_12">
                                                <div class="footer-icon align-center"><a class="top" href="#top"></a></div>
                                        </div>
                                </div></footer>
                </div> <!--! end of #container -->


                <!-- JavaScript at the bottom for fast page loading -->

                <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
                <script>window.jQuery || document.write('<script src="<?php echo $this->getAssetsUrl(); ?>/js/libs/jquery-1.6.2.min.js"><\/script>')</script>

                <!-- scripts concatenated and minified via ant build script-->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/excanvas.js"></script> <!-- Charts -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/common.js"></script> <!-- Generic functions -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/script.js"></script> <!-- Generic scripts -->


                <!-- end scripts-->

                <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
                     chromium.org/developers/how-tos/chrome-frame-getting-started -->
                <!--[if lt IE 7 ]>
                  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
                  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
                <![endif]-->

        </body>
</html>