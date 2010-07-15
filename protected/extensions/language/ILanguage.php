<?php

interface ILanguage {
	/*Returns compile command to be executed*/
	public function compile($pSourcePath , &$pOutput);

	/*Return run command to be executed*/
	public function run($pExecutablePath , $pMemoryLimit , $pTimeLimit);
}

?>
