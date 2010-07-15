<?php

class MassMailerForm extends CFormModel {

    public $csvfile;
    public $template;
    public $subject;
    public $from;
    public $fromName;
    public $replyTo;
    public $replyToName;

    public function init() {
        parent::init();
        $this->template =
                'Yth, $recipient

Ini adalah template untuk membuat email massal. Untuk menggunakan fitur ini, gunakan CSV dengan 2 kolom penting: recipient dan email ditambah 1 atau lebih kolom sebagai parameter. Kolom recipient adalah nama pengirim dan kolom email adalah email pengirim. Untuk menggunakan parameter pada template, tambahkan karakter \'$\' di depan nama kolom.

--
Signature email ditulis dalam template ini.';
    }

    public function rules() {
        return array(
            array('subject, template, from, fromName, replyTo , replyToName', 'required'),
            array('csvfile', 'file',
                'types' => 'csv',
                'allowEmpty' => false
            ),
        );
    }

    public function attributeLabels() {
        return array(
            'csvfile' => 'Berkas CSV',
            'template' => 'Konten',
        );
    }

}