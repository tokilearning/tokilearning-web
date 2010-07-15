<?php $this->setPageTitle("Status Grader");?>
<div class="dtable">
    <div class="drow">
        <span class="shead">Grader PID : <?php echo $pid;?></span>
        <span>
            <?php if ($running) : ?>
            <span style="color: #05F505; font-weight: bold;">Running</span>
            <?php else :?>
            <span class="grader-status" style="color: #F50505; font-weight: bold;">Stopped</span>
            <?php echo CHtml::ajaxButton("Jalankan", "grader/startengine", array(
                'success' => "function(data){
                                    if (data == 0) {
                                        alert('Grader running');
                                        $('.start-button').hide();
                                        $('.grader-status').text('Running');
                                        $('.grader-status').css('color' , '#05F505');
                                    }
                                    else {
                                        alert('Failed to run grader');
                                    }
                                }"
            ) , array('class' => 'start-button')); ?>
            <?php endif;?>
        </span>
    </div>
    <div class="drow">
        <span class="shead">Phantoms</span>
        <span>
            <?php foreach($phantoms as $submission):?>
            <?php echo CHtml::link('#'.$submission->id, array('supervisor/submission/view/id/' . $submission->id)); ?><br />
            <?php endforeach;?>
            <br/><br />
            <?php echo CHtml::link('Bersihkan', array('index?clearphantoms') , array('class' => 'linkbutton')); ?>
        </span>
    </div>
    <div class="drow">
        <span class="shead">Status terakhir</span>
        <span>
            <pre>
            <?php
                $output = array();
                exec("top -b -n1" , $output);
            ?>
            <?php foreach($output as $line) :?>
            <?php echo $line . "\n";?>
            <?php endforeach;?>
            </pre>
        </span>
    </div>
</div>
