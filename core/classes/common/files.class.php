<?php

class Files {

    public $messages;
    public $messages_count;
    public $errors;
    public $errors_count;

    public function __construct() {
        //$this->clear();
    }

    public function generateUniqueFileName($ext = '') {
//    public function generateUniqueFileName($path = '', $ext = '') {
        return "F" . strtoupper(uniqid(time())) . '.' . strtolower($ext);
//        $file_name = '';
//        while (1) {
//            $file_name = time() . rand(0, 1000);
//            if (!file_exists($path . $file_name . '.' . $ext))
//                break;
//        }
//        return $file_name . '.' . $ext;
    }

    public function upload($file_field, $file_name, $upload_dir, $max_size, $acceptable_extensions = '') {
        global $message;
        $temp_file = $_FILES[$file_field]['tmp_name'];

        if (!$this->fileValid($_FILES[$file_field]['name'], $acceptable_extensions)) {
            $message->addError('پسوند فایل مورد نظر معتبر نمی باشد.<br>پسوندهای مورد قبول: ' . $acceptable_extensions);
            return FALSE;
        }
        if ($_FILES[$file_field]['size'] > $max_size) {
            $message->addError('حجم فایل مورد نظر معتبر نمی باشد.<br>حداکثر حجم مورد قبول: ' . $max_size . ' بایت');
            return false;
        }
        if (!move_uploaded_file($temp_file, $upload_dir . $file_name)) {
            $message->addError('امکان آپلود فایل مورد نظر وجود ندارد.');
            return false;
        }
        return true;
    }

    public function extension($file_name) {
        $paths = pathinfo($file_name);
        return (isset($paths['extension'])) ? $paths['extension'] : '';
    }

    function getValidExtensions($acceptable_extensions, $sep = '|') {
        $acceptable_extensions = strtolower($acceptable_extensions);

        if (in_array('x-doc', explode('|', $acceptable_extensions))) {
            $acceptable_extensions.='|doc|docx|pdf';
        }
        if (in_array('x-zip', explode('|', $acceptable_extensions))) {
            $acceptable_extensions.='|zip|rar';
        }
        if (in_array('x-pic', explode('|', $acceptable_extensions))) {
            $acceptable_extensions.='|jpg|jpeg|png|gif';
        }
        if (in_array('x-office', explode('|', $acceptable_extensions))) {
            $acceptable_extensions.='|doc|docx|xls|xlsx|ppt|pptx|pdf';
        }
        if ($sep == '|')
            return $acceptable_extensions;
        else
            return str_replace('|', $sep, $acceptable_extensions);
    }

    public function fileValid($file_name, $acceptable_extensions) {
        global $auth;
        $file_extension = strtolower($this->extension($file_name));
        if (!$auth->fildValid($file_extension, $this->getValidExtensions($acceptable_extensions))) {
            return false;
        }
        return TRUE;
    }

}
