<?php

Yii::import("ext.language.ILanguage");

class Java implements ILanguage {
	private static $javac_path = "/usr/bin/javac";
	private static $java_path = "/usr/bin/java";

	public function __construct() {

	}

	public function compile($pSourcePath , &$pOutput) {
		$tCompileCmd = self::$javac_path . " -d /tmp " . $pSourcePath;
		exec($tCompileCmd , $output);

		foreach ($output as $line) {
			$output .= $line;
		}

		return "/tmp/" . basename($tCompileCmd , ".java");
	}

	public function run($pExecutablePath , $pMemoryLimit , $pTimeLimit) {
		
	}
}

?>
