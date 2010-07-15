<?php

echo "Username, Nama, Total, ";
$aliases = $this->getContest()->getProblemAliases();
foreach($aliases as $alias){
    echo "P".$alias.", ";
}
echo "\n";
foreach ($ranks as $rank) {
    printf("%s, %s, %s, ",
            $rank['username'],
            $rank['full_name'],
            $rank['total']
    );
    foreach($aliases as $alias) {
        echo $rank["P".$alias].", ";
    }
    echo "\n";
};
?>