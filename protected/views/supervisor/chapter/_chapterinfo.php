<div>
    <div class="dtable">
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'name');?></span>
            <span><?php echo $model->name;?></span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'nextChapter');?></span>
            <span><?php echo CHtml::link($model->nextChapter->name, array('view', 'id' => $model->nextChapter->id ));?></span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'previousChapter');?></span>
            <span><?php echo CHtml::link($model->previousChapter->name, array('view', 'id' => $model->previousChapter->id ));?></span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'description');?></span>
            <span><?php echo $model->description;?></span>
        </div>
        <div class="drow">
            <span class="shead">Rerata Waktu Penyelesaian</span>
            <span><?php echo $model->getAverageFinishTime() / 3600;?> jam</span>
        </div>
        <div class="drow">
            <span class="shead">Jumlah peserta aktif</span>
            <span><?php echo $model->getActiveParticipants();?></span>
        </div>
        <div class="drow">
            <span class="shead">Subbab</span>
            <span>
                <?php
                    $chapters = $model->getSubChapters();
                    foreach ($chapters as $chapter) {
                        echo CHtml::link($chapter->name, array('view', 'id' => $chapter->id )) . "<br />";
                    }
                ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Operasi</span>
            <span><a href="<?php echo $this->createUrl('supervisor/chapter/update' , array('id' => $model->id));?>">Sunting Bab Ini</a></span>
        </div>
    </div>
    <hr/>
</div>