<?php

// Global Functions

function loadClasses($classes, $subSite = 'common') {
    if (is_array($classes)) {

        foreach ($classes as $class)
            loadClass($class, $subSite);
    } else {
        loadClass($classes, $subSite);
    }
}

function loadClass($class, $subSite) {
    include_once "core/classes/" . $subSite . "/" . strtolower($class) . '.class.php';
    $GLOBALS[strtolower($class)] = new $class();
}

function setPage($file, $title = '', $header = '', $description = '', $keywords = '', $options = array()) {
    global $_CONFIGS, $_ENUM2FA;

    $cp = getCurPageName(FALSE);
    if (getCurPageName(FALSE) == 'project') {
        global $project;
        $_CONFIGS['Page']['Title'] = $_ENUM2FA['fa']['work'] . " " . getKeyword($_CONFIGS['Params'][1]) . ' :: ' . $project->getTitle((int) $_CONFIGS['Params'][1]);
    } else if (getCurPageName(FALSE) == 'user') {
        global $user;
        $_CONFIGS['Page']['Title'] = $_ENUM2FA['fa']['work'] . " " . getKeyword($_CONFIGS['Params'][1]) . ' :: ' . $user->getNickname((int) $_CONFIGS['Params'][1]);
//    } else if (getCurPageName(FALSE) == 'home') {
//        $_CONFIGS['Page']['Title'] = 'تایپایران' . ' :: ' . getKeyword() . ' :: ' . $title;
    } else {
        $_CONFIGS['Page']['Title'] = $_CONFIGS['Site']['Sub']['NickName'] . ' :: ' . $title;
    }


    $_CONFIGS['Page']['File'] = $file;
    $_CONFIGS['Page']['Header'] = $header;
    $_CONFIGS['Page']['Description'] = $description;
    $_CONFIGS['Page']['Keywords'] = $keywords;
    $_CONFIGS['Page']['Options'] = $options;
}

function commandEncode($data, $key = NULL) {
    global $_CONFIGS;
    if ($key === NULL)
        $key = md5($_CONFIGS['Security']['CommandKey']);
    $init_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $init_vect = mcrypt_create_iv($init_size, MCRYPT_RAND);
    return base64_encode($init_vect . mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $init_vect));
}

function commandDecode($data, $key = NULL) {
    global $_CONFIGS;
    if ($key === NULL)
        $key = md5($_CONFIGS['Security']['CommandKey']);
    $data = base64_decode($data);
    $init_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    if ($init_size > strlen($data))
        return FALSE;
    $init_vect = substr($data, 0, $init_size);
    $data = substr($data, $init_size);
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $init_vect), "\0");
}

function jCalendarFild($name, $extraAtt = "") {
    $srcPath = "plugin";
    $init =
            '<link rel="stylesheet" type="text/css" media="all" href="' . $srcPath . '/jscalendar/skins/calendar-blue2.css"/>'
            . '<!-- import the Jalali Date Class script -->'
            . '<script type="text/javascript" src="' . $srcPath . '/jscalendar/jalali.js"></script>'
            . '<!-- import the calendar script -->'
            . '<script type="text/javascript" src="' . $srcPath . '/jscalendar/calendar.js"></script>'
            . '<!-- import the calendar script -->'
            . '<script type="text/javascript" src="' . $srcPath . '/jscalendar/calendar-setup.js"></script>'
            . '<!-- import the language module -->'
            . '<script type="text/javascript" src="' . $srcPath . '/jscalendar/lang/calendar-fa.js"></script>';
    ///////
    $init.= '<style type="text/css"> '
            . '.calendar {'
            . 'direction: rtl;'
            . '}'
            . '#flat_calendar_1, #flat_calendar_2{'
            . 'width: 200px;'
            . '}'
            . '.example {'
            . 'padding: 10px;'
            . '}'
            . '.display_area {'
            . 'background-color: #FFFF88'
            . '}'
            . '</style>';
    $init.='<script type="text/javascript">
                Calendar.setup({
                    inputField     :    "' . $name . '_fild",   // id of the input field
                    button         :    "' . $name . '_fild",   // trigger for the calendar (button ID)
                    ifFormat       :    "%Y/%m/%d",       // format of the input field
                    dateType	   :	"jalali",
                    weekNumbers    : false,
                    eventName      : "dblclick"
                });
            </script>';
    //-----------------------------------------------
    $init2 = '<script type="text/javascript">
                Calendar.setup({
                    inputField     :    "' . $name . '_fild",   // id of the input field
                    button         :    "' . $name . '_btn",   // trigger for the calendar (button ID)
                    ifFormat       :    "%Y/%m/%d",       // format of the input field
                    dateType	   :	"jalali",
                    weekNumbers    : false
                });
            </script>';
    // check inputs-----------------
    $onchange = " onblur=\"
            var E=document.getElementById('" . $name . "_fild');
            var F1,F2,F3,Es=E.value;
            var n=Es.toString().length;
            if(n!=0){
            var d=-1,m,y,i=0;
            //firs value
            for(F1='';i<n && !(Es[i]=='/' || Es[i]=='\\\' || Es[i]=='-' || Es[i]=='.' );i++)
                F1+=Es[i];
            F1<=31?d=F1*1:y=F1*1;
            // 2nd value, month
            for(F2='',i++;i<n&& !(Es[i]=='/' || Es[i]=='\\\' || Es[i]=='-' || Es[i]=='.');i++)
                F2+=Es[i];
            m=F2<=12 ? F2*1:'12';
            // 3th value
            for(F3='',i++;i<n&& !(Es[i]=='/' || Es[i]=='\\\' || Es[i]=='-' || Es[i]=='.');i++)
                F3+=Es[i];
            d==-1?(d=F3<=31?F3*1:d='31'):y=F3*1;
            //year corector
            if(y && y<100){
                y='13'+y;
            }
            y=y?y+'0000':'1000';
            y=y.substr(0, 4);
            E.value=y+'/'+(m!=0?(m<10?'0'+m:m):'01')+'/'+(d!=0?(d<10?'0'+d:d):'01');
            }//if
            
       \" ";

    $oninput = " oninput=\"
        var m=document.getElementById('" . $name . "_fild');
        var n=m.value.toString().length;
        var o='';
        for(var i=0;i<n;i++){
            if((m.value[i]<='9' && m.value[i]>='0') || m.value[i]=='-'  || m.value[i]=='/' || m.value[i]=='\\\' || m.value[i]=='.' ){
                o+=m.value[i];
            }
        }
        m.value=o;
        \" ";
    //--------------------
    $out = '<input autocomplete="off" id="' . $name . '_fild" name="' . $name . '"  type="text" ' . $extraAtt . $oninput . $onchange . '>'
//            . ' <img id="' . $name . '_btn" src="' . $srcPath . '/jscalendar/cal.png" style="vertical-align: top;" />'
            . $init . $init2;
    return $out;
}

function NumTextFild($name, $extraAtt, $max, $min = 0) {
    // min is only for negative value
    if ($min > 0) {
        $min = 0;
    }

    $oninput = "oninput=\"
    var m=document.getElementById('" . $name . "_fild');
    var n=m.value.toString().length;
    var o='';
    if(n>0 &&((m.value[0]<='9' && m.value[0]>='0') || m.value[0]=='-'|| m.value[0]=='+')){
        o+=m.value[0];
    }
    for(var i=1;i<n;i++){
        if((m.value[i]<='9' && m.value[i]>='0') || m.value[i]=='.'){
            o+=m.value[i];
        }
    }
    while(o>" . $max . "){
        var os=o.toString();
        var n=os.length;
        var o0='';
        for(var i=1;i<n;i++){
            o0+=os[i];
        }
        o=o0;
    }
    if(o<" . $min . "){
    o=" . $min . ";
    }
    m.value=o;
    \"";

//    return '<input type="number" min="' . $min . '" step="10" dir="ltr" id="' . $name . '_fild" name="' . $name . '" ' . $oninput . ' ' . $extraAtt . ' > ';
//    return '<input type="text" dir="ltr" id="' . $name . '_fild" name="' . $name . '" ' . $oninput . ' ' . $extraAtt . ' > ';
    return '<input type="text" min="' . $min . '" max="' . $max . '" dir="ltr" class="number" name="' . $name . '"  ' . $extraAtt . ' > ';
}

function uploadFild($name_id, $extraClass, $path, $maxsize, $valids, $itemLimit = 1) {
    global $subSite, $files, $user;
    $data['path'] = $path;
    $data['subsite'] = $subSite;
    $data['user'] = $user->id;
    $data['valids'] = $valids;
    $data['maxsize'] = $maxsize;
    $code = commandEncode(json_encode($data));
    $itemLimit_1 = $itemLimit == 1 ? '$("#' . $name_id . ' .qq-upload-button-selector").hide();' : '';
    $itemLimit_1_empty = $itemLimit == 1 ? '$("#' . $name_id . ' .qq-upload-button-selector").show();' : '';

    $valids = $files->getValidExtensions($valids, '","');
    $out = '<script src="medias/scripts/jquery.fineuploader-4.2.1.min.js" type="text/javascript"></script>
    <style>
    .qq-progress-bar-container-selector{direction:rtl;text-align:right}
    .qq-uploader{position:relative;width:100%}
    .qq-upload-button{display:block;padding: 3px 10px;min-width: 175px;}
    .qq-upload-spinner{background:url("medias/images/icons/loading.gif");display:inline-block;width:15px;height:15px;vertical-align:text-bottom;}
    .qq-drop-processing{display:block}
    .qq-upload-retryable .qq-upload-retry{display:inline;}
    .qq-upload-list .qq-upload-success{background-color:#5DA30C;color:#FFF;padding: 3px;}
    .qq-upload-list .qq-upload-fail{background-color:#D60000;color:#FFF;padding: 3px;}
    .qq-progress-bar{display:block;width:0;height:15px;margin-top: 3px;}
    .qq-hide{display:none}
    </style>
    <script  type="text/javascript">
        seedtime=new Date().getTime();
        function genrateName(id,name){
            var ext = name.toLowerCase().split(".").pop();
            return "F"+seedtime+"U"+curUser.id+"I"+id+"."+ext;
        }
        function setInputValue(a,name_id){
            qqFiles=new Array();
            while(a.length){
                var e=a.pop();
                if(e.status=="upload successful")
                    qqFiles.push(genrateName(e.id,e.originalName));
            }
            var str=JSON.stringify(qqFiles);
            $("#"+name_id+"_hidden").val(str);
        }
        qqParams_' . $name_id . '={
            type: "file",
            ajax: "1",
            info:"' . $code . '"
        }
        $(document).ready(function () {
           fu= $("#' . $name_id . '").fineUploader({
                request: {
                    endpoint: "/webservice?func=upload",
                },
                deleteFile: {
                    enabled: true, 
                    endpoint: "/webservice?func=delete&uuid=",
                    params:qqParams_' . $name_id . ',
                    method:"POST"
                },
                validation: {
                    itemLimit: ' . $itemLimit . ',
                    allowedExtensions: ["' . $valids . '"],
                    sizeLimit: ' . $maxsize . '
                },
                callbacks: {
                    onSubmitted: function (id, name) {
                        qqParams_' . $name_id . '.name=genrateName(id ,name);
                        this.setParams(qqParams_' . $name_id . ');
                        ' . $itemLimit_1 . '
                        try{
                            $(".wait_' . $name_id . '").attr("disabled","disabled");
                        }catch(ex){}
                    },
                    onUpload: function (id, name) {
                        $(".wait_' . $name_id . '").removeAttr("disabled");
                    },
                    onDeleteComplete: function (id, name) {
                     ' . $itemLimit_1_empty . '
                         setInputValue(this.getUploads(),"' . $name_id . '");
                    },
                    onComplete: function (s, f,o,h ) {
                         setInputValue(this.getUploads(),"' . $name_id . '");
                    }
                    
                },
                
                text: {
                    uploadButton: "Upload a file",
                    cancelButton: "Cancel",
                    retryButton: "Retry",
                    failUpload: "خطا",
                    dragZone: "Drop files here to upload",
                    formatProgress: "{percent}% of {total_size}",
                    waitingForResponse: "درحال بارگذاری ..."
                },
                messages: {
                    typeError: "فرمت فایل انتخاب شده معتبر نمی باشد<br/> فرمت های مجاز: {extensions} <br/> فایل: {file}",
                    sizeError: "حجم فایل انتخاب شده بیش از حد مجاز است<br/> حجم مجاز: {sizeLimit}",
                    tooManyItemsError: "امکان ارسال بیش از {itemLimit} فایل وجود ندارد"
                },
                showMessage: function(message) {
                    mhkform.info(message);
                }
            });
        });
    </script>
    
    <script type="text/template" id="qq-template">
        <div class="qq-uploader-selector qq-uploader">
            <!--        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                        <span>Drop  here to upload</span>
                    </div>-->
            <div class="qq-upload-button-selector qq-upload-button">
                <div>
                انتخاب فایل
                <i class="fa fa-cloud-upload"></i>
                </div>
            </div>
            <div class="qq-upload-list-selector qq-upload-list english">
                <div>
                    <div class="qq-progress-bar-container-selector">
                        <div class="qq-progress-bar-selector qq-progress-bar bg-theme"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"></span>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <img class="qq-upload-cancel-selector qq-upload-cancel" width="16px" src="medias/images/icons/delete.png" align="absmiddle" />
                    <img class="qq-upload-retry-selector qq-upload-retry" width="16px" src="medias/images/icons/refresh.png" align="absmiddle" />
                    <img class="qq-upload-delete-selector qq-upload-delete" width="16px" src="medias/images/icons/delete.png" align="absmiddle" />
                    <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </div>
            </div>
        </div>
    </script>
    <span class="input ' . $extraClass . '" style="width: 100%;max-width:200px; padding: 0">
        <span id="' . $name_id . '"  ></span>
        <input type="hidden" name="' . $name_id . '" id="' . $name_id . '_hidden" />
    </span>';
    echo $out;
}

function roundPrice($price) {
    return round($price / (100)) * 100;
}

function getCurPageName($addParam = TRUE) {
    global $page, $_CONFIGS;
    $pl = strlen($page[0]);
    $p = strtolower(substr($page[0], 0, $pl - 4));
    $p = str_replace("manage/", "", $p);
    $p = str_replace("common/", "", $p);
    $p = str_replace("type/", "", $p);
    $p = str_replace("translate/", "", $p);
    $p = str_replace("graphic/", "", $p);
    if ($addParam && isset($_CONFIGS['Params'][1]))
        $p.='_' . $_CONFIGS['Params'][1];
    if ($addParam && isset($_CONFIGS['Params'][2]))
        $p.='_' . $_CONFIGS['Params'][2];

    return $p;
//    $p=$_REQUEST['request'];
//    $p=  str_replace("/", "", $p);
//    return $p;
}

function getKeyword($i = -1) {

    $rk = array(
        ' آنلاین'
        , ' اینترنتی'
        , ' تخصصی'
        , ' فوری'
        , ' فارسی'
    );

    if ($i == -1)
        $i = rand(0, 10);

    return $rk[fmod((float) $i, count($rk))];
}

//function pageBreaker($href, $href_query, $curPagePara, $numElement, $ajax_con = "#ajax_content", $numPerPage = 20) {
//    global $_CONFIGS;
//    $curPage = isset($_CONFIGS['Params'][$curPagePara]) ? $_CONFIGS['Params'][$curPagePara] : 1;
//
//    $numPage = intval($numElement / $numPerPage + 0.9);
//
//    $href_query = $href_query ? ("&" . $href_query) : $href_query;
//
//    $ajax_con = $ajax_con ? (',\'' . $ajax_con . '\'') : '';
//    $ajaxS = ' onclick="mhkform.ajax( $(this).attr(\'ahref\')+ \'' . '?ajax=1\'' . $ajax_con . ')" ';
//    $ajaxS = $ajax_con !== FALSE ? $ajaxS : '';
//    $href_tsg = $ajax_con !== FALSE ? 'href="#" ahref' : 'href';
//
//    if ($numPage > 1) {
//        $startIndex = 0;
//        echo '<br><p><b><span style=""> ' . 'صفحه' . ': </span></b><b> ';
//        if ($numPage > 10 && $curPage > 5) {
//            echo '|<span style=""> ';
//            echo '<a ' . $href_tsg . '="' . $href . '_' . ($curPage - 1) . $href_query . '" ' . $ajaxS . ' >' . '<' . '</a>';
//            echo ' </span>';
//            if ($numPage - $curPage < 5)
//                $startIndex = $numPage - 10;
//            else {
//                $startIndex = $curPage - 5;
//            }
//        }
//        for ($index1 = $startIndex; $index1 < $numPage && $index1 - $startIndex < 10; $index1++) {
//            echo '|<span style=""> ';
//            if ($curPage == $index1 + 1)
//                echo '<span style="background-color: gray;"> <b>' . ($index1 + 1) . '</b></span>';
//            else {
//                echo '<a ' . $href_tsg . '="' . $href . '_' . ($index1 + 1) . $href_query . '" ' . $ajaxS . ' >' . ($index1 + 1) . '</a>';
//            }
//            echo ' </span>';
//        }
//        if ($numPage > 10 && $curPage < $numPage - 5) {
//            echo '|<span style=""> ';
//            echo '<a ' . $href_tsg . '="' . $href . '_' . ($curPage + 1) . $href_query . '" ' . $ajaxS . ' >' . '>' . '</a>';
//            echo ' </span>';
//        }
//        echo '|</b></p>';
//    }
//}
//
//function pageLimit($curPagePara, $numPerPage = 20) {
//    global $_CONFIGS;
//    $curPage = isset($_CONFIGS['Params'][$curPagePara]) ? $_CONFIGS['Params'][$curPagePara] : 1;
//    return ' LIMIT ' . (($curPage - 1) * $numPerPage) . ', ' . $numPerPage . ' ';
//}
//function priceFormat($price) {
//
//    $outPrice = '';
//    while (strlen($price) > 0) {
//        if (strlen($price) > 3) {
//            $outPrice = ',' . substr($price, -3).$outPrice;
//            $price = substr($price, 0, strlen($price) - 3);
//        } else {
//            $outPrice =  $price.$outPrice;
//            $price = "";
//        }
//    }
//
//    return $outPrice;
//}

function mh_getIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function suportBrowser() {
    if (isset($_REQUEST['ajax']))
        return TRUE;
    if (getCurPageName(FALSE) != 'home')
        if (getCurPageName(FALSE) != 'panel')
            return TRUE;

    if (preg_match('/(?i)MSIE 10/', $_SERVER['HTTP_USER_AGENT']))
        return TRUE;
    if (preg_match('/(?i)MSIE [1-9]/', $_SERVER['HTTP_USER_AGENT']))// if IE<=9
        return FALSE;
    if (preg_match('/Opera/i', $_SERVER['HTTP_USER_AGENT']))
        return FALSE;
    return TRUE;
}

function isSubType() {
    global $subSite;
    return $subSite == 'type';
}

function isSubTranslate() {
    global $subSite;
    return $subSite == 'translate';
}

function isSubGraphic() {
    global $subSite;
    return $subSite == 'graphic';
}