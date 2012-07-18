
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

                <title>404 :: Grape - Professional &amp; Flexible Admin Template</title>
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
                <script src="js/libs/modernizr-2.0.6.min.js"></script>
        </head>

        <body class="special-page">

                <!-- Begin of #container -->
                <div id="container">
                        <?php echo $content;?>
                </div> <!--! end of #container -->


                <!-- JavaScript at the bottom for fast page loading -->

                <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
                <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>

                <!-- scripts concatenated and minified via ant build script-->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
                <script defer src="<?php echo $this->getAssetsUrl(); ?>/js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
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
