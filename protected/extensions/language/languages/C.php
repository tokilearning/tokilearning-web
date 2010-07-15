<?php

Yii::import("ext.language.ILanguage");


class C implements ILanguage {
	private static $gcc_path = "/usr/bin/gcc";

	public function __construct() {

	}

	public function compile($pSourcePath , &$pOutput) {
		$retval = "";
		$execPath = Sandbox::getTempName();
		$tCompileCmd = self::$gcc_path . " -x c -std=c99 -o " . $execPath . " " . $pSourcePath;

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
