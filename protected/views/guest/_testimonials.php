<?php
Yii::app()->clientScript->registerCss('testimonials-css', '
    div.testimonial {padding:3px 15px;}
    div.testimonial .content {font-size:10px;margin:0px;font-style:italic;}
    div.testimonial .author {margin:0px;float:right;font-size:11px;font-weight:bold;}
');
?>
<?php
$testimonials = array(
    array(
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac ipsum sit amet quam euismod imperdiet. Fusce suscipit, felis eget.',
        'author' => 'John Doe',
    ),
    array(
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac ipsum sit amet quam euismod imperdiet. Fusce suscipit, felis eget.',
        'author' => 'Jane Doe',
    ),
    array(
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac ipsum sit amet quam euismod imperdiet. Fusce suscipit, felis eget.',
        'author' => 'John Doe',
    ),
    array(
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac ipsum sit amet quam euismod imperdiet. Fusce suscipit, felis eget.',
        'author' => 'Jane Doe',
    ),
);
?>
<div style="border-bottom: 1px solid #bbb;font-weight:bold;margin:1px 7px;">Testimonials</div>
<?php foreach ($testimonials as $testimonial): ?>
    <div class="testimonial">
        <p class="content"><?php echo $testimonial['content']; ?></p>
        <span class="author">~ <?php echo $testimonial['author']; ?></span>
        
    </div>
    <div style="clear:both"></div>
<?php endforeach; ?>