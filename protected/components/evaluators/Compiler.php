<?php

class Compiler {
    
    public static function compile($sourcepath, $sourcelang, &$outputpath = NULL, $parameter = NULL){
        $compiletimelimit = 1;
        $compilememorylimit = 32000;
        $parameter = (!is_null($parameter) && isset($parameter[$sourcelang])) ? $parameter[$sourcelang] : '';

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
                $compilecmd = sprintf("%s -x c++ -std=c99 %s -o %s %s -O2",
                            $compiler_cpp_path,
                            $parameter,
                            $outputpath,
                            $sourcepath
                        );
                break;
            case 'c' :
                $compilecmd = sprintf("%s -x c -std=c99 %s -o %s %s",
                            $compiler_gcc_path,
                            $parameter,
                            $outputpath,
                            $sourcepath
                        );
                break;
            default :
                echo " Error in grading: Source language not recognized";
                throw new CompilerException(CompilerException::ERR_LANGUAGE_UNRECOGNIZED);
                break;
        }
        $sandboxparam = sprintf("-e -m %s -w %s", $compilememorylimit, $compiletimelimit);
        $sandboxexec = $compilecmd;
        $sandboxoutput = "";
        $retval = 0;
        try {
            Sandbox::execute($sandboxparam, $sandboxexec, &$sandboxoutput, &$retval);
        } catch (SandboxException $ex) {
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