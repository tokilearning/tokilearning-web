Username, Nama Panjang, Waktu Terakhir, Halaman Terakhir
<?php foreach($activities as $activity){
    printf("%s, %s, %s, %s\n",
            $activity['username'], $activity['full_name'], $activity['last_activity'], $activity['last_page']);
}?>