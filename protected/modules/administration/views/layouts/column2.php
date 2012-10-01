<?php /* @var $this Controller */ ?>
<?php $this->beginContent('/layouts/main'); ?>
<!-- left menu starts -->
<div class="span2 main-menu-span">
        <div class="well nav-collapse sidebar-nav">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                                array('label' => 'Main', 'itemOptions' => array('class' => 'nav-header')),
                                array('label' => 'Dashboard', 'url' => array('dashboard/index'), 'itemOptions' => array(
                                                'class' => 'menu-icon-home',
                                )),
                                array('label' => 'Users', 'url' => array('users/index'), 'itemOptions' => array(
                                                'class' => 'menu-icon-user',
                                ))
                        ),
                        'id' => 'sidebarmenu',
                        'htmlOptions' => array(
                                'class' => 'nav nav-tabs nav-stacked main-menu',
                        )
                ));
                ?>
        </div><!--/.well -->
</div><!--/span-->
<!-- left menu ends -->

<noscript>
<div class="alert alert-block span10">
        <h4 class="alert-heading">Warning!</h4>
        <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
</div>
</noscript>

<div id="content" class="span10">
        <!-- content starts -->
        <div>
                <ul class="breadcrumb">
                        <li>
                                <a href="#">Home</a> <span class="divider">/</span>
                        </li>
                        <li>
                                <a href="#">File Manager</a>
                        </li>
                </ul>
        </div>

        <?php echo $content; ?>
        <!--/row-->
        <!-- content ends -->
</div><!--/#content.span10-->
<?php $this->endContent(); ?>