<?php

/**
 * Wrapper class for curl communication
 */
class Channel {
    private $mCurlChannel;
    private $mBaseUrl;
    private $mCookieFile;

    public function __construct($pBaseurl) {
        $this->mBaseUrl = $pBaseUrl;
        $this->setup();
    }

    private function setup() {
        $this->mCookieFile = tempnam("/tmp" , "COOKIE");

        $this->mCurlChannel = curl_init();
        //curl_setopt($this->mCurlChannel , CURLOPT_URL , "http://localhost/lx");
        curl_setopt($this->mCurlChannel , CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($this->mCurlChannel , CURLOPT_COOKIEJAR, $this->mCookieFile);
        //curl_setopt($this->mCurlChannel, CURLOPT_POST, 1);
        //curl_setopt($this->mCurlChannel, CURLOPT_POSTFIELDS, "LoginForm[username]=$username&LoginForm[password]=$password");
        //$content = curl_exec($this->mCurlChannel);
    }

    private function setOption($option , $value) {
        curl_setopt($this->mCurlChannel , $option , $value);
    }

    public function execute($pUrl , $pMethod , $pPostFields = "") {
        $this->setOption(CURLOPT_URL , $pUrl);

        if ($pMethod == "POST") {
            $this->setOption(CURLOPT_POST , 1);
            $this->setOption(CURLOPT_POSTFIELDS , $pPostFields);
        }


        $tContent = curl_exec($this->mCurlChannel);

        return $tContent;
    }
}

?>
