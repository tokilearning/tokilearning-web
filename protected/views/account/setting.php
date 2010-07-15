<?php
Yii::app()->clientScript->registerCss('account-css', '
    .briefing {border:1px dotted #bbb;margin:0px 0px 5px 0px; padding:2px 5px;color:#000;background:#eee;}
    ');
?>

<?php $this->setPageTitle("Sunting Profil"); ?>
<div id="information" class="section2">
    <h3 class="title">Informasi Akun</h3>
    <div class="briefing">Informasi di bawah bersangkutan dengan akses kamu di sini. Isilah dengan benar.</div>

    <?php if (Yii::app()->user->hasFlash('accountUpdateSuccess')): ?>
        <div class="errorMessage">
            Informasi baru dari akun kamu telah tersimpan.
        </div>
    <?php endif; ?>

        <div class="dtable">
        <?php echo CHtml::beginForm(); ?>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'username'); ?></span>
            <span>
				<?php if($model->isDummy()):?>
					<?php echo CHtml::activeTextField($model, 'username', array('size' => '30', 'readonly' => 'readonly')); ?>
				<?php else:?>
					<?php echo CHtml::activeTextField($model, 'username', array('size' => '30' , 'readonly' => 'readonly')); ?>
				<?php endif;?>
                <?php echo CHtml::error($model, 'username'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'full_name'); ?></span>
            <span>
                <?php if ($model->isDummy()) :?>
					<?php echo CHtml::activeTextField($model, 'full_name', array('size' => '30', 'readonly' => 'readonly')); ?>
                <?php else:?>
					<?php echo CHtml::activeTextField($model, 'full_name', array('size' => '30')); ?>
				<?php endif;?>
				<?php echo CHtml::error($model, 'full_name'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'email'); ?></span>
            <span>
                <?php echo CHtml::activeTextField($model, 'email', array('size' => '30')); ?>
                <?php echo CHtml::error($model, 'email'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'password'); ?></span>
            <span>
                <?php echo CHtml::passwordField('User[password]', '', array('size' => '30')); ?>
                <?php echo CHtml::error($model, 'password'); ?>
            </span>
        </div>
        <div class="drow">
            <span></span>
            <span>
<?php echo CHtml::submitButton('Simpan'); ?>
            </span>
        </div>
<?php echo CHtml::endForm(); ?>
            </div>
        </div>

        <div id="information" class="section2">
            <h3 class="title">Informasi Umum</h3>
            <div class="briefing">Informasi di bawah adalah informasi umum yang ditampilkan di halaman profil. Informasi berikut tidak harus diisi.</div>
            <div class="dtable">
<?php echo CHtml::beginForm($this->createUrl('updateGeneral')); ?>
                <div class="drow">
                    <span class="shead"><?php echo CHtml::activeLabel($model, 'phone'); ?></span>
                    <span>
                        <?php echo CHtml::activeTextField($model, 'phone', array('size' => '30')); ?>
                        <?php echo CHtml::error($model, 'phone'); ?>
                    </span>
                </div>
                <div class="drow">
                    <span class="shead"><?php echo CHtml::activeLabel($model, 'address'); ?></span>
                    <span>
                        <?php echo CHtml::activeTextArea($model, 'address', array('style' => 'height: 50px;')); ?>
                        <?php echo CHtml::error($model, 'address'); ?>
                    </span>
                </div>
                <div class="drow">
                    <span class="shead"><?php echo CHtml::activeLabel($model, 'site_url'); ?></span>
                    <span>
<?php echo CHtml::activeTextArea($model, 'site_url', array('style' => 'height:50px;')); ?>
                <div style="border:1px dotted #ddd;font-size:9px;padding:1px;margin:2px 0px;">
                    Web, Blog, Facebook, Twitter. Pisahkan koma jika ingin mengisi banyak.
                </div>
<?php echo CHtml::error($model, 'site_url'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'institution'); ?></span>
            <span>
                <?php echo CHtml::activeTextArea($model, 'institution', array('style' => 'height:50px;')); ?>
<?php echo CHtml::error($model, 'institution'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'institution_address'); ?></span>
            <span>
                <?php echo CHtml::activeTextArea($model, 'institution_address', array('size' => '30')); ?>
<?php echo CHtml::error($model, 'institution_address'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'institution_phone'); ?></span>
            <span>
                <?php echo CHtml::activeTextField($model, 'institution_phone', array('size' => '30')); ?>
<?php echo CHtml::error($model, 'institution_phone'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead"><?php echo CHtml::activeLabel($model, 'city'); ?></span>
            <span>
                <?php echo CHtml::activeTextField($model, 'city', array('size' => '30')); ?>
                <?php echo CHtml::error($model, 'city'); ?>
            </span>
        </div>
        <div class="drow">
            <span class="shead">Site</span>
            <span>
                <?php
                    $siteList = array(
                        'UI' => 'Universitas Indonesia',
                        'ITB' => 'Institut Teknologi Bandung',
                        'UGM' => 'Universitas Gadjah Mada',
                        'ITS' => 'Institut Teknologi Sepuluh November',
                        'IPB' => 'Institut Pertanian Bogor',
			'UNAND' => 'Universitas Andalas',
                        'Online' => 'Online'                    
                    );                
                ?>
                <?php echo CHtml::activeRadioButtonList($model, 'additional_information', $siteList, array('size' => '30')); ?>
                <?php echo CHtml::error($model, 'additional_information'); ?>
            </span>
        </div>
        <div class="drow">
            <span></span>
            <span>
<?php echo CHtml::submitButton('Simpan'); ?>
            </span>
        </div>
<?php echo CHtml::endForm(); ?>
    </div>
</div>
