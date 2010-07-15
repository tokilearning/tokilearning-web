<?php

class Compiler {
    
    public static function compile($sourcepath, $sourcelang, $outputpath = NULL, $parameter = NULL, &$compiler_output){
        $compiletimelimit = 2;
        $compilememorylimit = 64000;
        $parameter = (!is_null($parameter) && isset($parameter[$sourcelang])) ? $parameter[$sourcelang] : '';
	if (is_null($outputpath))
        {
            $outputpath = Sandbox::getTempName();
        }
        $compiler_gcc_path = Yii::app()->params->config['evaluator']['compiler']['compiler_gcc_path'];
        $compiler_cpp_path = Yii::app()->params->config['evaluator']['compiler']['compiler_cpp_path'];
        $compiler_fpc_path = Yii::app()->params->config['evaluator']['compiler']['compiler_fpc_path'];

        switch($sourcelang) {
            case 'pp' :
            case 'pas' :
                $compilecmd = sprintf("%s %s -o%s %s",
                            $compiler_fpc_path,
                            $parameter,
                            $outputpath,
                            $sourcepath
                        );
                break;
            case 'c++' :
            case 'cpp' :
                $compilecmd = sprintf("ulimit -u unlimited; %s -x c++ %s -o %s %s -O2 -ansi -fno-asm -Wall -DONLINE_JUDGE",
                            $compiler_cpp_path,
                            $parameter,
                            $outputpath,
                            $sourcepath
                        );
                break;
            case 'c' :
                $compilecmd = sprintf("ulimit -u unlimited; %s -x c -std=c99 %s -o %s %s -ansi -fno-asm -O2 -Wall -DONLINE_JUDGE",
                            $compiler_gcc_path,
                            $parameter,
                            $outputpath,
                            $sourcepath
                        );
                break;
            default :
                echo " Error in grading: Source language not recognized\n";
                throw new CompilerException(CompilerException::ERR_LANGUAGE_UNRECOGNIZED);
                break;
        }
        $sandboxparam = sprintf("-e -m %s -t %s", $compilememorylimit, $compiletimelimit);
        $sandboxexec = $compilecmd;
        $sandboxoutput = "";
        $retval = 0;
        try {
            Sandbox::execute($sandboxparam, $sandboxexec, &$sandboxoutput, &$retval);
	    $compiler_output = $sandboxoutput;
        } catch (SandboxException $ex) {
            $compiler_output = $sandboxoutput;
            throw new CompilerException(CompilerException::ERR_COMPILE_ERROR);
        }
        
        if ($retval != 0) {
            throw new CompilerException(CompilerException::ERR_COMPILE_ERROR);
        }
        if ($sourcelang == 'pascal') {
            unlink($sourcepath.".o");
        }
        return $outputpath;
    }
}
