<?php

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $event Event */
/* @var $message Message */
/* @var $persiandate PersianDate */
/* @var $project Project */
include_once 'core/classes/common/base_project.class.php';

class Project extends BaseProject {

    public function submit() {
        global $_PRICES, $database, $user, $message, $event;
        $data = json_decode($_POST['data'], TRUE);

        $title = $data['title'];
        $lang = $data['lang'];
        $guess_page_num = ((int) $data['pagecount']);
        $description = $data['desc'];
        $fileName = $data['files'];
        $out_format = $data['output'];
        $type = $data['type'];
        $bid_type = $data['bid_type'];
        $selectkarfarma = 'li';
        $max_price = $data['price'];
        $min_rate = 0;
        $private_typist_id0 = $data['private_worker'];
        $discountCode = '';
        $earnest = 0;
        $editMode = FALSE;
        $demo = $this->extractDemoFile($fileName, $data['demo']);
        ////////////////////////////////////
        $lang = strtoupper($lang);
        $expire_interval = $data['time_interval'];
        $private_typist_id = '';

        switch ($type) {
            case "Referer":
                $sum = $max_price;
                $private_typist_id = $private_typist_id0;
                break;
            case "Private":
                $sum = $max_price;
                $private_typist_id = $private_typist_id0;
                break;
            case "Protected":
                $sum = $guess_page_num * $_PRICES['user'][$lang]; //nc?  if rate is biger 2
                break;
            case "Public":
                $selectkarfarma = strtolower($selectkarfarma);
                $max_price = (int) $max_price;

                if ($selectkarfarma == 'mr') {
                    $min_rate = (int) $min_rate;
                }
                $sum = $max_price;
                break;
            case "Agency":
                if (!$user->isAgency()) {
                    $message->addError('نوع پروژه را مشخص کنید');
                    return false;
                }
                $sum = $guess_page_num * $_PRICES['agency'][$lang];
                break;
        }

        $discountCode = strtoupper($discountCode);
        $dis = new Discount($discountCode, ($user->id));
        if ($dis->isValid()) {
            $discountCode = ""; //nc?
        } else {
            $discountCode = "";
        }

        $max_price = $sum;
        $earnest = (int) $earnest;
        $sum = $sum * (1 - $dis->p) - ($dis->e);
        $sum = roundPrice($sum);
        $earnest0 = roundPrice($sum * $_PRICES['P_USER']);

        if ($earnest && $earnest != 0) {
            if ($earnest >= $earnest0) {
                $earnest0 = $earnest;
            } else {
                
            }
        }

        if ($type == "Agency") {
            $earnest0 = 0;
            $lock_price = $max_price;
        } elseif ($type == "Public" && $selectkarfarma == 'li') {
            $earnest0 = 0;
            $lock_price = $sum;
        } elseif ($type == "Private") {
            $earnest0 = 0;
            $lock_price = $sum;
        } else {
            $lock_price = $earnest0;
        }




        $earnest = $earnest0;

        $can_cancel = $out_format == 'ONLINE' ? 0 : 1;
        //////////////////////

        if ($editMode) {
            $message->addError('امکان ویرایش وجود ندارد');
            return false;
        } else {
            $database->insert('projects', array(
                'user_id' => (int) $user->id,
                'state' => 'Open',
                'submit_date' => time(),
                'title' => $title,
                'lang' => $lang,
                'level' => $data['level'],
                'demo' => $demo,
                'guess_page_num' => $guess_page_num,
                'description' => $description,
                'file_name' => $fileName,
//            'expire_time' => $expire_date_time,
                'expire_interval' => $expire_interval,
                'output' => $out_format,
                'type' => $type,
                'bid_type' => $bid_type,
                'selection_method' => $selectkarfarma,
                'max_price' => $max_price,
                'lock_price' => $lock_price,
                'min_rate' => $min_rate,
                'private_typist_id' => $private_typist_id,
                'discount_code' => $discountCode,
                'earnest' => (int) $earnest,
                'can_cancel' => $can_cancel,
                'verified' => ($user->isAgency()) ? 1 : Event::$V_AUTO_ACC,
            ));
            $pid = $database->getInsertedId();
        }
        if ($editMode) {
            
        } else {
            $event->call($user->id, Event::$T_PROJECT, Event::$A_SUBMIT
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        }
        // nc? send sms for private and protected project
        if ($type == "Private") {
            $event->call($private_typist_id, Event::$T_PROJECT, Event::$A_PRIVATE
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        }

//        if ($type == "Referer") {
        $refer = $user->getDiscountReferer();
        if ($refer && $refer > 0) {
            $event->call($refer, Event::$T_PROJECT, Event::$A_REFERER
                    , array(
                'prjtitle' => $title,
                'prjid' => $pid,
            ));
        }

        // nc? send sms for private and protected project
        if ($data['type'] == "Private") {
            $event->call($data['private_worker'], Event::$T_PROJECT, Event::$A_PRIVATE
                    , array(
                'prjtitle' => $data['title'],
                'prjid' => $pid,
            ));
        }

        return $pid;
    }

    private function extractDemoFile($filename, $demo) {
        if (strlen($demo) > 5)
            return $demo;

        global $files;
        $demos = array();
        try {
            $b = json_decode($filename, TRUE);
            foreach ($b as $value) {
                if (substr($value, 0, 4) != "http") {
                    if ($files->fileValid($value, "x-pic")) {
                        $demos[] = $value;
                        return json_encode($demos);
                    }
                } else {
                    // link to other site // check if is pic
                }
            }

            foreach ($b as $value) {
                if (substr($value, 0, 4) != "http" && $files->fileValid($value, "zip")) {
                    $zip = new ZipArchive;
//                    $path = __DIR__ . '/../../../uploads/type/project/';
                    $path = 'uploads/type/project/';
                    $zip->open($path . $value);
                    $findTozip = FALSE;
                    for ($i = 0; $i < $zip->numFiles && !$findTozip; $i++) {
                        $name = $zip->getNameIndex($i);
                        if ($files->fileValid($name, "x-pic")) {
                            $ufn = $files->generateUniqueFileName($files->extension($name));
                            $fz = $path . $ufn;
                            $demo = $ufn;
                            $findTozip = TRUE;
                            // Read from Zip and write to disk
                            $fpr = $zip->getStream($name);
                            $fpw = fopen($fz, 'w');
                            while ($data = fread($fpr, 1024)) {
                                fwrite($fpw, $data);
                            }
                            fclose($fpr);
                            fclose($fpw);
                        }

                        $zip->close();
                    }
                    if ($findTozip) {
                        $demos[] = $demo;
                        return json_encode($demos);
                    }
                }
            }
        } catch (Exception $exc) {
            
        }
        return "";
    }

    public function getOldProjectFiles($age = 10) {
        global $database;
        $keepFile = array();
        $ti = time() - $age * 24 * 60 * 60;
        $ps = $database->fetchAll($database->select('projects', 'demo,file_name', "WHERE state='Run' OR submit_date > '$ti' "));
        foreach ($ps as $p) {
            if (strpos($p['demo'], ']')) {
                $b = json_decode($p['demo'], TRUE);
                foreach ($b as $value) {
                    if (substr($value, 0, 4) != "http") {
                        $keepFile[$value] = 1;
                    }
                }
            }
            if (strpos($p['file_name'], ']')) {
                $b = json_decode($p['file_name'], TRUE);
                foreach ($b as $value) {
                    if (substr($value, 0, 4) != "http") {
                        $keepFile[$value] = 1;
                    }
                }
            } else {
                if (substr($p['file_name'], 0, 4) != "http") {
                    $keepFile[$p['file_name']] = 1;
                }
            }
        }

        Report::addLog($keepFile);
        return $keepFile;
    }

}
