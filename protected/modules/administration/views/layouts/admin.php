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

                                <!-- left menu starts -->
                                <div class="span2 main-menu-span">
                                        <div class="well nav-collapse sidebar-nav">
                                                <ul class="nav nav-tabs nav-stacked main-menu">
                                                        <li class="nav-header hidden-tablet">Main</li>
                                                        <li class="active"><a href="index.html" class="ajax-link"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li>
                                                        <li><a href="ui.html" class="ajax-link"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
                                                        <li><a href="form.html" class="ajax-link"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
                                                        <li><a href="chart.html" class="ajax-link"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
                                                        <li><a href="typography.html" class="ajax-link"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
                                                        <li><a href="gallery.html" class="ajax-link"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
                                                        <li class="nav-header hidden-tablet">Sample Section</li>
                                                        <li style="margin-left: -2px;"><a href="table.html" class="ajax-link"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
                                                        <li><a href="calendar.html" class="ajax-link"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
                                                        <li><a href="grid.html" class="ajax-link"><i class="icon-th"></i><span class="hidden-tablet"> Grid</span></a></li>
                                                        <li><a href="file-manager.html" class="ajax-link"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
                                                        <li><a href="tour.html"><i class="icon-globe"></i><span class="hidden-tablet"> Tour</span></a></li>
                                                        <li><a href="icon.html" class="ajax-link"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
                                                        <li><a href="error.html"><i class="icon-ban-circle"></i><span class="hidden-tablet"> Error Page</span></a></li>
                                                        <li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>
                                                </ul>
                                                <label for="is-ajax" class="hidden-tablet" id="for-is-ajax"><div class="checker" id="uniform-is-ajax"><span><input type="checkbox" id="is-ajax" style="opacity: 0;"></span></div> Ajax on menu</label>
                                        </div><!--/.well -->
                                </div><!--/span-->
                                <!-- left menu ends -->

                                <noscript>
                                &lt;div class="alert alert-block span10"&gt;
                                &lt;h4 class="alert-heading"&gt;Warning!&lt;/h4&gt;
                                &lt;p&gt;You need to have &lt;a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank"&gt;JavaScript&lt;/a&gt; enabled to use this site.&lt;/p&gt;
                                &lt;/div&gt;
                                </noscript>

                                <div class="span10" id="content">
                                        <!-- content starts -->


                                        <div>
                                                <ul class="breadcrumb">
                                                        <li>
                                                                <a href="#">Home</a> <span class="divider">/</span>
                                                        </li>
                                                        <li>
                                                                <a href="#">Dashboard</a>
                                                        </li>
                                                </ul>
                                        </div>
                                        <div class="sortable row-fluid ui-sortable">
                                                <a href="#" class="well span3 top-block" data-rel="tooltip" data-original-title="6 new members.">
                                                        <span class="icon32 icon-red icon-user"></span>
                                                        <div>Total Members</div>
                                                        <div>507</div>
                                                        <span class="notification">6</span>
                                                </a>

                                                <a href="#" class="well span3 top-block" data-rel="tooltip" data-original-title="4 new pro members.">
                                                        <span class="icon32 icon-color icon-star-on"></span>
                                                        <div>Pro Members</div>
                                                        <div>228</div>
                                                        <span class="notification green">4</span>
                                                </a>

                                                <a href="#" class="well span3 top-block" data-rel="tooltip" data-original-title="$34 new sales.">
                                                        <span class="icon32 icon-color icon-cart"></span>
                                                        <div>Sales</div>
                                                        <div>$13320</div>
                                                        <span class="notification yellow">$34</span>
                                                </a>

                                                <a href="#" class="well span3 top-block" data-rel="tooltip" data-original-title="12 new messages.">
                                                        <span class="icon32 icon-color icon-envelope-closed"></span>
                                                        <div>Messages</div>
                                                        <div>25</div>
                                                        <span class="notification red">12</span>
                                                </a>
                                        </div>

                                        <div class="row-fluid">
                                                <div class="box span12">
                                                        <div class="box-header well">
                                                                <h2><i class="icon-info-sign"></i> Introduction</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-setting btn-round" href="#"><i class="icon-cog"></i></a>
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content">
                                                                <h1>Charisma <small>free, premium quality, responsive, multiple skin admin template.</small></h1>
                                                                <p>Its a live demo of the template. I have created Charisma to ease the repeat work I have to do on my projects. Now I re-use Charisma as a base for my admin panel work and I am sharing it with you :)</p>
                                                                <p><b>All pages in the menu are functional, take a look at all, please share this with your followers.</b></p>

                                                                <p class="center">
                                                                        <a class="btn btn-large btn-primary" href="http://usman.it/free-responsive-admin-template"><i class="icon-chevron-left icon-white"></i> Back to article</a> 
                                                                        <a class="btn btn-large" href="http://usman.it/free-responsive-admin-template"><i class="icon-download-alt"></i> Download Page</a>
                                                                </p>
                                                                <div class="clearfix"></div>
                                                        </div>
                                                </div>
                                        </div>

                                        <div class="row-fluid sortable ui-sortable">
                                                <div class="box span4">
                                                        <div class="box-header well">
                                                                <h2><i class="icon-th"></i> Tabs</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-setting btn-round" href="#"><i class="icon-cog"></i></a>
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content">
                                                                <ul id="myTab" class="nav nav-tabs">
                                                                        <li class="active"><a href="#info">Info</a></li>
                                                                        <li><a href="#custom">Custom</a></li>
                                                                        <li><a href="#messages">Messages</a></li>
                                                                </ul>

                                                                <div class="tab-content" id="myTabContent">
                                                                        <div id="info" class="tab-pane active">
                                                                                <h3>Charisma <small>a fully featued template</small></h3>
                                                                                <p>Its a fully featured, responsive template for your admin panel. Its optimized for tablet and mobile phones. Scan the QR code below to view it in your mobile device.</p> <img src="img/qrcode136.png" class="charisma_qr center" alt="QR Code">
                                                                        </div>
                                                                        <div id="custom" class="tab-pane">
                                                                                <h3>Custom <small>small text</small></h3>
                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor.</p>
                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. Nulla tellus elit, varius non commodo eget, mattis vel eros. In sed ornare nulla. Donec consectetur, velit a pharetra ultricies, diam lorem lacinia risus, ac commodo orci erat eu massa. Sed sit amet nulla ipsum. Donec felis mauris, vulputate sed tempor at, aliquam a ligula. Pellentesque non pulvinar nisi.</p>
                                                                        </div>
                                                                        <div id="messages" class="tab-pane">
                                                                                <h3>Messages <small>small text</small></h3>
                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. Nulla tellus elit, varius non commodo eget, mattis vel eros. In sed ornare nulla. Donec consectetur, velit a pharetra ultricies, diam lorem lacinia risus, ac commodo orci erat eu massa. Sed sit amet nulla ipsum. Donec felis mauris, vulputate sed tempor at, aliquam a ligula. Pellentesque non pulvinar nisi.</p>
                                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor.</p>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div><!--/span-->

                                                <div class="box span4">
                                                        <div data-original-title="" class="box-header well">
                                                                <h2><i class="icon-user"></i> Member Activity</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content">
                                                                <div class="box-content">
                                                                        <ul class="dashboard-list">
                                                                                <li>
                                                                                        <a href="#">
                                                                                                <img src="http://www.gravatar.com/avatar/f0ea51fa1e4fae92608d8affee12f67b.png?s=50" alt="Usman" class="dashboard-avatar"></a>
                                                                                        <strong>Name:</strong> <a href="#">Usman
                                                                                        </a><br>
                                                                                        <strong>Since:</strong> 17/05/2012<br>
                                                                                        <strong>Status:</strong> <span class="label label-success">Approved</span>                                  
                                                                                </li>
                                                                                <li>
                                                                                        <a href="#">
                                                                                                <img src="http://www.gravatar.com/avatar/3232415a0380253cfffe19163d04acab.png?s=50" alt="Sheikh Heera" class="dashboard-avatar"></a>
                                                                                        <strong>Name:</strong> <a href="#">Sheikh Heera
                                                                                        </a><br>
                                                                                        <strong>Since:</strong> 17/05/2012<br>
                                                                                        <strong>Status:</strong> <span class="label label-warning">Pending</span>                                 
                                                                                </li>
                                                                                <li>
                                                                                        <a href="#">
                                                                                                <img src="http://www.gravatar.com/avatar/46056f772bde7c536e2086004e300a04.png?s=50" alt="Abdullah" class="dashboard-avatar"></a>
                                                                                        <strong>Name:</strong> <a href="#">Abdullah
                                                                                        </a><br>
                                                                                        <strong>Since:</strong> 25/05/2012<br>
                                                                                        <strong>Status:</strong> <span class="label label-important">Banned</span>                                  
                                                                                </li>
                                                                                <li>
                                                                                        <a href="#">
                                                                                                <img src="http://www.gravatar.com/avatar/564e1bb274c074dc4f6823af229d9dbb.png?s=50" alt="Saruar Ahmed" class="dashboard-avatar"></a>
                                                                                        <strong>Name:</strong> <a href="#">Saruar Ahmed
                                                                                        </a><br>
                                                                                        <strong>Since:</strong> 17/05/2012<br>
                                                                                        <strong>Status:</strong> <span class="label label-info">Updates</span>                                  
                                                                                </li>
                                                                        </ul>
                                                                </div>
                                                        </div>
                                                </div><!--/span-->

                                                <div class="box span4">
                                                        <div data-original-title="" class="box-header well">
                                                                <h2><i class="icon-list-alt"></i> Realtime Traffic</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content">
                                                                <div style="height: 190px; padding: 0px; position: relative;" id="realtimechart"><canvas class="base" width="322" height="190"></canvas><canvas class="overlay" width="322" height="190" style="position: absolute; left: 0px; top: 0px;"></canvas><div style="font-size:smaller" class="tickLabels"><div style="color:#545454" class="yAxis y1Axis"><div style="position:absolute;text-align:right;top:177px;right:304px;width:18px" class="tickLabel">0</div><div style="position:absolute;text-align:right;top:132px;right:304px;width:18px" class="tickLabel">25</div><div style="position:absolute;text-align:right;top:86px;right:304px;width:18px" class="tickLabel">50</div><div style="position:absolute;text-align:right;top:41px;right:304px;width:18px" class="tickLabel">75</div><div style="position:absolute;text-align:right;top:-5px;right:304px;width:18px" class="tickLabel">100</div></div></div></div>
                                                                <p class="clearfix">You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</p>
                                                                <p>Time between updates: <input type="text" style="text-align: right; width:5em" value="" id="updateInterval"> milliseconds</p>
                                                        </div>
                                                </div><!--/span-->
                                        </div><!--/row-->

                                        <div class="row-fluid sortable ui-sortable">
                                                <div class="box span4">
                                                        <div data-original-title="" class="box-header well">
                                                                <h2><i class="icon-list"></i> Buttons</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-setting btn-round" href="#"><i class="icon-cog"></i></a>
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content buttons">
                                                                <p class="btn-group">
                                                                        <button class="btn">Left</button>
                                                                        <button class="btn">Middle</button>
                                                                        <button class="btn">Right</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-small"><i class="icon-star"></i> Icon button</button>
                                                                        <button class="btn btn-small btn-primary">Small button</button>
                                                                        <button class="btn btn-small btn-danger">Small button</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-small btn-warning">Small button</button>
                                                                        <button class="btn btn-small btn-success">Small button</button>
                                                                        <button class="btn btn-small btn-info">Small button</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-small btn-inverse">Small button</button>
                                                                        <button class="btn btn-large btn-primary btn-round">Round button</button>
                                                                        <button class="btn btn-large btn-round"><i class="icon-ok"></i></button>
                                                                        <button class="btn btn-primary"><i class="icon-edit icon-white"></i></button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-mini">Mini button</button>
                                                                        <button class="btn btn-mini btn-primary">Mini button</button>
                                                                        <button class="btn btn-mini btn-danger">Mini button</button>
                                                                        <button class="btn btn-mini btn-warning">Mini button</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-mini btn-info">Mini button</button>
                                                                        <button class="btn btn-mini btn-success">Mini button</button>
                                                                        <button class="btn btn-mini btn-inverse">Mini button</button>
                                                                </p>
                                                        </div>
                                                </div><!--/span-->

                                                <div class="box span4">
                                                        <div data-original-title="" class="box-header well">
                                                                <h2><i class="icon-list"></i> Buttons</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-setting btn-round" href="#"><i class="icon-cog"></i></a>
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content  buttons">
                                                                <p>
                                                                        <button class="btn btn-large">Large button</button>
                                                                        <button class="btn btn-large btn-primary">Large button</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-large btn-danger">Large button</button>
                                                                        <button class="btn btn-large btn-warning">Large button</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-large btn-success">Large button</button>
                                                                        <button class="btn btn-large btn-info">Large button</button>
                                                                </p>
                                                                <p>
                                                                        <button class="btn btn-large btn-inverse">Large button</button>
                                                                </p>
                                                                <div class="btn-group">
                                                                        <button class="btn btn-large">Large Dropdown</button>
                                                                        <button data-toggle="dropdown" class="btn btn-large dropdown-toggle"><span class="caret"></span></button>
                                                                        <ul class="dropdown-menu">
                                                                                <li><a href="#"><i class="icon-star"></i> Action</a></li>
                                                                                <li><a href="#"><i class="icon-tag"></i> Another action</a></li>
                                                                                <li><a href="#"><i class="icon-download-alt"></i> Something else here</a></li>
                                                                                <li class="divider"></li>
                                                                                <li><a href="#"><i class="icon-tint"></i> Separated link</a></li>
                                                                        </ul>
                                                                </div>

                                                        </div>
                                                </div><!--/span-->

                                                <div class="box span4">
                                                        <div data-original-title="" class="box-header well">
                                                                <h2><i class="icon-list"></i> Weekly Stat</h2>
                                                                <div class="box-icon">
                                                                        <a class="btn btn-setting btn-round" href="#"><i class="icon-cog"></i></a>
                                                                        <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
                                                                        <a class="btn btn-close btn-round" href="#"><i class="icon-remove"></i></a>
                                                                </div>
                                                        </div>
                                                        <div class="box-content">
                                                                <ul class="dashboard-list">
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-arrow-up"></i>                               
                                                                                        <span class="green">92</span>
                                                                                        New Comments                                    
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-arrow-down"></i>
                                                                                        <span class="red">15</span>
                                                                                        New Registrations
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-minus"></i>
                                                                                        <span class="blue">36</span>
                                                                                        New Articles                                    
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-comment"></i>
                                                                                        <span class="yellow">45</span>
                                                                                        User reviews                                    
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-arrow-up"></i>                               
                                                                                        <span class="green">112</span>
                                                                                        New Comments                                    
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-arrow-down"></i>
                                                                                        <span class="red">31</span>
                                                                                        New Registrations
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-minus"></i>
                                                                                        <span class="blue">93</span>
                                                                                        New Articles                                    
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a href="#">
                                                                                        <i class="icon-comment"></i>
                                                                                        <span class="yellow">254</span>
                                                                                        User reviews                                    
                                                                                </a>
                                                                        </li>
                                                                </ul>
                                                        </div>
                                                </div><!--/span-->
                                        </div><!--/row-->
                                        <!-- content ends -->
                                </div><!--/#content.span10-->
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