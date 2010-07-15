<?php
Yii::app()->clientScript->registerCss('slideshow-css', '
        #slideshow-wrapper {margin:5px auto;min-height:300px;}
        #slideshow {width:610px;list-style-type:none;margin:5px;border:1px solid #bbb;padding:0px;background:#1e1b1a;}
        #slideshow li {background:#111;width:610px;}
        #slideshow li div.image-wrapper {height:200px;background:#f1efe6;width:610px;}
        #slideshow li h1 {padding:10px;font-size:26px;background:#1e1b1a;color:#fefefe;margin:0px;}
        #slideshow li p {padding:10px;background:#1e1b1a;color:#fefefe;margin:0px;font-size:15px;font-weight:normal;}
        #slideshow-pager {list-style-type:none;padding:0px;margin-left:5px;}
        #slideshow-pager li {float:left;}
        #slideshow-pager li a {margin:2px;display:block;height:8px;width:8px;text-decoration:none;border:5px solid #1e1b1a;-moz-border-radius: 1em/5em;}
        #slideshow-pager li a.activeSlide {margin:2px;display:block;height:8px;width:8px;text-decoration:none;border:5px solid #3c2c00;-moz-border-radius: 1em/5em;}
        #slideshow-pager li a:focus {margin:2px;display:block;height:8px;width:8px;text-decoration:none;border:5px solid #3c2c00;-moz-border-radius: 1em/5em;}
        #information-links-wrapper {border-top:1px solid #111;padding: 15px 0px 15px 0px;}
        #information-links-wrapper ul {list-style-type:none;padding:0px;margin-left:5px;}
        #information-links-wrapper ul li {float:left;margin:0px 25px 0px 0px;}
        #information-links-wrapper ul a {display:block;text-decoration:none;font-size:20px;font-weight:bold;}
        #information-links-wrapper ul a:hover {color:#000;}

    ');
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/scripts/jquery/cycle/jquery.cycle.min.js");
Yii::app()->clientScript->registerScript('slideshow-js', '
        $(\'#slideshow\').cycle({
            fx: \'fade\',
            pager:  \'#slideshow-pager\',
            pagerAnchorBuilder: function(idx, slide) {
              return \'<li><a href="#">&nbsp;</a></li>\';
            }
        });
    ');
?>
<?php
$slideitems = array(
    array(
        "imagesrc" => "",
        "title" => "Manage Your Sports Tournament Online",
        "content" => "Manage your tournament from various kinds of sports from soccer, table tennis, taekwondo, karate, etc using online efficient and effective tools available at <strong>Turnamen</strong>.",
    ),
    array(
        "imgsrc" => "",
        "title" => "Manage at Your Desktop",
        "content" => "Download our tournament management system for your desktop. Manage your tournament offline and then synchronize your offline data to your online account."
    ),
    array(
        "imgsrc" => "",
        "title" => "Use Real Time Judging Tools",
        "content" => "Use our newest sports judging technology to help you judge your tournament more accurately. These real time tools are easily attached to our desktop application."
    ),
    array(
        "imgsrc" => "",
        "title" => "Get Social",
        "content" => "Invite your friends to view and contribute to your tournaments. See all others tournaments being held worldwide"
    )
);
?>
<div id="slideshow-wrapper">
    <ul id="slideshow">
        <?php foreach ($slideitems as $slideitem) : ?>
            <li>
                <div class="image-wrapper">

                </div>
                <h1><?php echo $slideitem['title']; ?></h1>
                <p><?php echo $slideitem['content']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
    <ol id="slideshow-pager"></ol>
    <div style="clear:both;"></div>
</div>
<div id="information-links-wrapper">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items'=>array(
            array('label'=>'Site Tour', 'url' => array('/tour')),
            array('label'=>'Desktop App', 'url' => array('/desktop')),
            array('label'=>'Gadget Store', 'url' => array('/store')),
            array('label'=>'Development Blog', 'url' => '#'),
            ),
        ));
    ?>
    <div style="clear:both;"></div>
</div>