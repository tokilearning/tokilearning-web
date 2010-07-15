<?php

Yii::import("ext.language.ILanguage");

class Pascal implements ILanguage {
	private static $fpc_path = "/usr/bin/fpc";
	
	public function __construct() {
		
	}

	public function compile($pSourcePath , &$pOutput , $pArgs = NULL) {
		$retval = "";
		$execPath = Sandbox::getTempName();
		$tCompileCmd = self::$fpc_path . " -o" . $execPath . " " . $pSourcePath;

		try {
            Sandbox::execute("-e -m 64000 -t 2", $tCompileCmd, $sandboxoutput, $retval);
			$retval = $execPath;
        } catch (SandboxException $ex) {
			$retval = "";
        }

		$pOutput = $sandboxoutput;
		return $retval;
	}

	public function run($pExecutablePath , $pMemoryLimit , $pTimeLimit) {
		$tRunCommand = "/bin/mo-evalbox -e -f -a 2 -t " . $pTimeLimit . " -m " . $pMemoryLimit . " 2>&1 -- " . $pExecutablePath;
		return $tRunCommand;
	}
}

?>
