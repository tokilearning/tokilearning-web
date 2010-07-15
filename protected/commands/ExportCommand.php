<?php

class ExportCommand extends CConsoleCommand {

    private $problems = array();
    
    public function run($args) {
        if ($args[0] == "-s") {
            $this->problems[] = Problem::model()->findByPK($args[1]);
        } else if ($args[0] == "-r") {
            for ($i = $args[1] ; $i <= $args[2] ; $i++) {
                $problem = Problem::model()->findByPK($i);
                if ($problem !== null)
                    $this->problems[] = $problem;
            }
        }
        
        $output = "";
        $result = Problem::exportProblem($this->problems, $output , "lx-export.zip") . "\n";
        echo $output;
        echo "Zip created : " . $result;
    }

}

?>
