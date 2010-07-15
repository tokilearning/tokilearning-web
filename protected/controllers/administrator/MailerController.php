<?php

/**
 *
 */
class MailerController extends CAdminController {

    public $defaultAction = 'create';
    private $_model;

    public function actionCreate(){
        $model = new MassMailerForm();
        if (isset($_POST['MassMailerForm'])){
            $model->attributes = $_POST['MassMailerForm'];
            if ($model->validate()) {
                //TODO: Hardcode
                $this->_model = $model;
                $filename = $_FILES['MassMailerForm']['tmp_name']['csvfile'];
                $data = $this->parseCSV($filename);
                $this->sendMassMail($model->subject, $model->template, $data);
                //return;
            }
        }
        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionArchives(){
        $this->render('archives');
    }

    private function parseCSV($filename){
        $content = array();
        if (($handle = fopen($filename, "r")) !== FALSE) {
            $header = fgetcsv($handle);
            if ($header !== FALSE){
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $row = array();
                    foreach($data as $key => $value){
                        $row[$header[$key]] = $value;
                    }
                    $content[] = $row;
                }
                return $content;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private function sendMassMail($subject, $template, $data){
        foreach($data as $row){
            $recipient = $row['recipient'];
            $to = $row['email'];
			$attachment = isset($row['attachment']) ? $row['attachment'] : NULL;

            $content = $template;
            foreach($row as $key => $value){
                $replace = '$'.$key;
                $content = str_replace($replace, $value, $content);
            }
            $this->sendMail($recipient, $to, $subject, $content, $attachment);
        }
    }

//    private function sendMail($recipient, $to, $subject, $content){
//        echo "TO   : $recipient <$to>\n";
//        echo "FROM : itbpc2010@gmail.com\n";
//        echo "REPLY-TO : itbpc2010@gmail.com\n";
//        echo "SUBJECT  : $subject\n";
//        echo "CONTENT \n";
//        echo $content;
//        echo "\n=============\n";
//    }

    private function sendMail($recipient, $to, $subject, $content, $attachment = NULL){
        $model = $this->_model;
        $message = new Message;
        $message->setBody($content, 'text/plain');
        $message->subject = $subject;
        //$message->addTo('Petra Novandi <petra.barus@gmail.com>')
        $message->setTo(array($to => $recipient));
        //$message->from = 'ITB Programming Contest <itbpc@if.itb.ac.id>';
        //$message->setFrom(array('itbpc2010@gmail.com' => 'ITB Programming Contest'));
        $message->setFrom(array($model->from => $model->fromName));
        $message->setCc(array('toki.learning@gmail.com' => 'TOKI Learning Center'));
        //$message->setBcc(array('itbpc-committee@googlegroups.com' => 'ITBPC Comittee'));
        //$message->setReplyTo(array('itbpc2010@gmail.com' => 'ITB Programming Contest'));
        $message->setReplyTo(array($model->replyTo => $model->replyToName));
		if ($attachment != NULL)
			$message->attach(Swift_Attachment::fromPath($attachment));
        Yii::app()->mail->send($message);
    }

}