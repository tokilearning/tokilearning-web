Yth, <?php echo $model->full_name;?>


Email ini dikirim karena seseorang telah melakukan permintaan perubahan sandi akun Anda di situs TOKI Learning Center. Jika Anda merasa tidak melakukannya harap abaikan email ini.
Jika Anda menginginkan perubahan sandi maka ikuti pranala di bawah dan masukkan sandi baru Anda.

<?php echo Yii::app()->createAbsoluteUrl('guest/changepassword', array('user' => $model->username, 'key' => $model->activation_code));?>


Atau anda dapat masuk ke halaman 
<?php echo Yii::app()->createAbsoluteUrl('guest/changepassword');?> 


dan melakukan perubahan dengan memasukkan kode di bawah
<?php echo $model->activation_code;?>


Jika terdapat kesalahan harap hubungi kami lewat kontak yang tertera pada situs TOKI Learning Center.

Terima kasih,

#This email sent because you have registered at TOKI Learning Center. If this email is not for you, let us know
#Email ini dikirim karena anda telah mendaftar di TOKI Learning Center. Jika email ini bukan untuk anda, beritahu kami
--
Tim Olimpiade Komputer Indonesia
Biro Institut Teknologi Bandung
http://lc.toki.if.itb.ac.id
toki.learning@gmail.com
