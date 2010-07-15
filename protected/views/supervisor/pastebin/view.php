<?php $this->setPageTitle("Paste Bin - #".$model->id);?>
<?php $this->renderPartial('_menu'); ?>

<?php
CSyntaxHighlighter::registerFiles($model->type);
Yii::app()->clientScript->registerCss('pastebin-css', '
    #pastebin {padding:5px;}
    #meta {background: #eee; margin: 10px 0; padding: 4px 15px;}
    #meta abbr {}
    #code {}
');
?>

<div id="pastebin">
<div id="meta">
    #<?php echo $model->id;?> oleh <?php echo $model->owner->getFullnameLink();?> pada <?php echo CDateHelper::timespanAbbr($model->created_date);?>
</div>
<pre id="code" class="brush: <?php echo $model->type;?>"><?php echo CHtml::encode($model->content);?></pre>
</div>
