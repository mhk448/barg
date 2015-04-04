<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jul 23, 2013 , 1:33:36 PM
 * mhkInfo:
 */

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

class Pager {

    public function getParamById($tableName, $exit = TRUE, $pIndex = 1, $data_base = NULL) {
        global $_CONFIGS;
        if (!$data_base) {
            global $database;
            $data_base = $database;
        }
        if (!isset($_CONFIGS['Params'][$pIndex]) || !is_numeric($_CONFIGS['Params'][$pIndex])) {
            if ($exit) {
                Report::addLog("Error page ");
                header('Location: error');
                exit;
            }
            return FALSE;
        }
        $res = $data_base->select($tableName, '*', $data_base->whereId($_CONFIGS['Params'][$pIndex]));
        $out = $data_base->fetchAssoc($res);

        if (!$out) {
            if ($exit) {
//                Report::addLog("Error page ");
                header('Location: error');
                exit;
            }
            return FALSE;
        }
        return $out;
    }

    public function getComParamById($tableName, $exit = TRUE, $pIndex = 1) {
        global $cdatabase;
        return $this->getParamById($tableName, $exit, $pIndex, $cdatabase);
    }

    private $numPerPage;
    private $countPages;
    private $searchTableColumn = null;

    public function getList($table_name, $columns_list = "*", $whereConditions = "", $conditions = "", $searchTableColumn = null, $numPerPage = 20, $data_base = null) {
        if (!$data_base) {
            global $database;
            $data_base = $database;
        }
        $this->searchTableColumn = $searchTableColumn;
        $this->numPerPage = $numPerPage;
        $numElement = $data_base->selectCount($table_name, $whereConditions . $this->getSearchCondition($whereConditions) . $conditions);
        $this->countPages = intval($numElement / $this->numPerPage + 0.9);

        $res = $data_base->select($table_name, $columns_list, $whereConditions . $this->getSearchCondition($whereConditions) . $conditions . $this->getPageLimit($numPerPage));
        return $data_base->fetchAll($res);
    }

    public function getComList($table_name, $columns_list = "*", $whereConditions = "", $conditions = "", $searchTableColumn = null, $numPerPage = 20) {
        global $cdatabase;
        return $this->getList($table_name, $columns_list, $whereConditions, $conditions, $searchTableColumn, $numPerPage, $cdatabase);
    }

    public function pageBreaker($href = NULL, $href_query = "", $ajax_con = "#ajax_content") {

        if ($href === NULL)
            $href = getCurPageName();

        $curPage = $this->getCurPageNumber();


        $href_new = isset($_REQUEST['new']) ? "&new=1" : "";
        $href_query = $href_query ? ("&" . $href_query) : $href_query;
        $href_query = $href_query . $href_new;

        $ajax_con = $ajax_con ? (',\'' . $ajax_con . '\'') : '';
        $ajaxS = ' onclick="mhkform.ajax( $(this).attr(\'ahref\')+ \'' . '?ajax=1\'' . $ajax_con . ')" ';
        $ajaxS = $ajax_con !== FALSE ? $ajaxS : '';
        $href_tsg = $ajax_con !== FALSE ? 'href="#" ahref' : 'href';

        if ($this->countPages > 1) {
            $startIndex = 0;
            echo '<br><p class="pager" style="direction:rtl"><b><span style=""> ' . 'صفحه' . ': </span></b><b> ';
            if ($this->countPages > 10 && $curPage > 5) {
                echo '<span style=""> ';
                echo '<a ' . $href_tsg . '="' . $href . '_pn' . ($curPage - 1) . $href_query . '" ' . $ajaxS . ' >' . '<' . '</a>';
                echo ' </span>';
                if ($this->countPages - $curPage < 5)
                    $startIndex = $this->countPages - 10;
                else {
                    $startIndex = $curPage - 5;
                }
            }
            for ($index1 = $startIndex; $index1 < $this->countPages && $index1 - $startIndex < 10; $index1++) {
                echo '<span style=""> ';
                if ($curPage == $index1 + 1)
                    echo '<span class="bg-theme" style="padding: 0 4px;border: 1px solid gray;"> <b>' . ($index1 + 1) . '</b></span>';
                else {
                    echo '<a ' . $href_tsg . '="' . $href . '_pn' . ($index1 + 1) . $href_query . '" ' . $ajaxS . ' >' . ($index1 + 1) . '</a>';
                }
                echo ' </span>';
            }
            if ($this->countPages > 10 && $curPage < $this->countPages - 5) {
                echo '<span style=""> ';
                echo '<a ' . $href_tsg . '="' . $href . '_pn' . ($curPage + 1) . $href_query . '" ' . $ajaxS . ' >' . '>' . '</a>';
                echo ' </span>';
            }
            echo '</b></p>';
        }
    }

    public function getPageLimit() {
        return ' LIMIT ' . (($this->getCurPageNumber() - 1) * $this->numPerPage) . ', ' . $this->numPerPage . ' ';
    }

    public function getCurPageNumber() {
        global $_CONFIGS;
        $curPage = 1;
        $param = end($_CONFIGS['Params']);
        if (strlen($param) > 2) {
            $curPageStr = strtolower(substr(end($_CONFIGS['Params']), 0, 2));
            if ($curPageStr == "pn") {
                $curPage = intval(substr(end($_CONFIGS['Params']), 2));
            }
        }
        return $curPage;
    }

    public function showSearchBox($title = "", $ajax = FALSE) {
        $value = '';
        if (isset($_REQUEST['pager_s']) and
                $_REQUEST['pager_s']) {
            $value = ' value="' . $_REQUEST['pager_s'] . '"';
        }
        $ac = $_REQUEST['request'];
        echo '<br/>
            <form method="POST" '
        . ($ajax ? '' : 'action="' . $ac . '"')
        . ' >
        ' . $title . '
                <input name="pager_s" id="pager_s" ' . $value . '/>
                <input class="active_btn" type="submit" value="جستجو" '
        . ($ajax ? 'onclick="mhkform.ajax(\'' . $ac . '?ajax=1&pager_s=\'+($(\'#pager_s\').val()));"' : '')
        . ' />
            </form>
        <br/>';
    }

    private function getSearchCondition($whereCondition) {
        global $database;
        $sc = " ";
        if ($this->searchTableColumn and
                isset($_REQUEST['pager_s']) and
                $_REQUEST['pager_s']) {
            $word = $database->escapeString($_REQUEST['pager_s']);
            if (substr($word, 0, 4) == "FULL")
                $word = substr($word, 4);
            else
                $word = '%' . $word . '%';
            if ($whereCondition)
                $sc .= " AND " . $this->searchTableColumn . " like '" . $word . "' ";
            else {
                $sc .= " WHERE " . $this->searchTableColumn . " like '" . $word . "' ";
            }
        }
        return $sc;
    }

}

?>
