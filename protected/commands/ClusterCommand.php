<?php

abstract class ClusterCommand extends CConsoleCommand {
	protected $cookieFile;
    protected $curlChannel;
    protected $baseUrl;
    protected $username;
    protected $password;
    
    protected function login($username , $password) {
        $this->cookieFile = tempnam("/tmp" , "COOKIE");
    
        $this->curlChannel = curl_init();
        curl_setopt($this->curlChannel , CURLOPT_URL , "http://".$this->baseUrl."/guest/appsignin");
        curl_setopt($this->curlChannel , CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($this->curlChannel , CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($this->curlChannel, CURLOPT_POST, 1);
        curl_setopt($this->curlChannel, CURLOPT_POSTFIELDS, "LoginForm[username]=$username&LoginForm[password]=$password");
        $content = curl_exec($this->curlChannel);
        if ($content == "FAILED")
            return false;
        else
            return true;
    }
    
    protected function createUrl($url) {
    	return "http://".$this->baseUrl."/".$url;
    }

    protected function downloadProblem($id , $file) {
        echo "Downloading problem details #" . $id . "\n";

        $f = fopen($file , "w");
        curl_setopt ($this->curlChannel, CURLOPT_URL, $this->createUrl("supervisor/cluster/getproblem/id/$id?key=itbitbitb"));
        //curl_setopt ($this->curlChannel, CURLOPT_FILE, $f);

        $content = curl_exec($this->curlChannel);
        //return $content;
        
        fclose($f);

        file_put_contents($file, $content);
        $f = new ZipArchive();
        $f->open($file);
        $f->extractTo(Yii::app()->params->config['evaluator']['problem']['problem_repository_path']);
        $f->close();
    }
}

?>
