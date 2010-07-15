<?php

Yii::import("ext.language.ILanguage");

class Cpp implements ILanguage {
	private static $gpp_path = "/usr/bin/g++";

	public function __construct() {

	}

	public function compile($pSourcePath , &$pOutput) {
		$retval = "";
		$execPath = Sandbox::getTempName();
		$tCompileCmd = self::$gpp_path . " -x c++ -o " . $execPath . " " . $pSourcePath . " -O2";

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
