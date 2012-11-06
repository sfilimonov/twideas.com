<?

define("E_SQL_DUPLICATE_KEY", 1062);
define("E_SQL_DUPLICATE_ENTRY", 1022);

$dup_sql_errors = array(E_SQL_DUPLICATE_KEY, E_SQL_DUPLICATE_ENTRY);


function CheckMySQL($res, $file = "", $line = "" , $sql = "") {
	if (!$res) {
		echo "<H3>SQL error</H3>";
		echo "<H4>Error ".mysql_errno().", '".mysql_error()."'</H4>";
		echo "<p>at $file:$line</p>Query:\n$sql\n";
		die ();
	}

	return $res;
}


class db {
// public

   // contructor
	function __construct($host, $database, $user, $password) {
		$this -> host = $host;
		$this -> database = $database;
		$this -> user = $user;
		$this -> password = $password;

		$this -> link = mysql_connect($host, $user, $password);
		
		if (!$this -> link) die ("<H4>Can't connect to SQL server</H4>");
		
		CheckMySQL(@mysql_select_db($database, $this -> link), __FILE__, __LINE__);
		$res = @mysql_query("SET CHARACTER SET UTF8", $this -> link);
		//$res = @mysql_query('SET NAMES cp1251', $this -> link);

	}

	// returns an object of the Select class
	function Select($query) {
		$res = CheckMySQL(@mysql_query($query, $this -> link), __FILE__, __LINE__, $query);
		return new Select($res, $this -> link);
	}

	// returns numbers of affected rows.
	// in case of error, returns -1
	function ExecSQL($query, $can_die = true) {
		$res = @mysql_query($query, $this -> link);
		//$res = @mysql_query('SET NAMES utf8', $this -> link);
		if ($can_die)
			CheckMySQL($res, "", "", $query);

		return mysql_affected_rows($this -> link);
	}

	// returns last error number
	function Errno() {
		return mysql_errno($this -> link);
	}

	// returns full text of the last error
	function ErrorText() {
		return mysql_error($this -> link);
	}

	function GetInsertID() {
		return @mysql_insert_id($this -> link);
	}

	function Commit() {
		return;
	}

//	private
	var $host;
	var $database;
	var $user;
	var $password;
	var $link;
}


//
class Select  {
// public
	var $RowCount; // a number of selected rows

	function Select($query_result, $link) {
		$this -> link = $link;
		$this -> result = $query_result;

		$this -> RowCount = mysql_num_rows($this -> result);
	}

	// Fetch a result row as an associative array
	function FetchArray () {
		return @mysql_fetch_array($this -> result);
	}

	function FetchRow () {
		return @mysql_fetch_row($this -> result);
	}
	
    function Value(){
		$value = @mysql_fetch_row($this -> result);
		return $value[0];
    }

	function FieldNames() {
		$result = array();
		$count = @mysql_num_fields($this -> result);

		for ($i = 0; $i < $count; $i++) {
			array_push($result, @mysql_field_name($this -> result, $i));
		}
		return $result;
	}

	function DataSeek($RowNumber) {
		return @mysql_data_seek($this -> result, $RowNumber);
	}

	function FieldType($FieldNumber) {
		return @mysql_field_type($this -> result, $FieldNumber);
	}

	function FreeResult() {
		@mysql_free_result($this -> result);
	}

//	private
	var $result;
}







/* Функция выполняет вставку записи в таблицу
  $table - имя таблицы
  $fields[]['name']  - имя поля в таблице
  $fields[]['value'] - значение, которое нужно вставить
  $fields[]['type']  - тип поля из деф-файла
*/
function insert_record_with_type($table, $fields) {
	global $db;
	$field_names = array();
	$field_values = array();
	$field = array();
	$i = 0;
	foreach ($fields as $c_field) {
		$field_names[$i] = $c_field['name'];
		
		$c_field['value'] = addslashes($c_field['value']);
		if ($c_field['type'] == "integer") $c_field['value'] = intval($c_field['value']);
		if ($c_field['type'] == "float") $c_field['value'] = floatval($c_field['value']);
		if (preg_match("/date/", $c_field['type']) && $c_field['value'] == "") {
			$field_values[$i] = $c_field['default'];
		}
		else {
			$field_values[$i] = "'".($c_field['value'] == '' && $c_field['default'] != '' ? $c_field['default'] : $c_field['value'])."'";
		}
		$field[$i] = "{$field_names[$i]}={$field_values[$i]}";
		$i++;
	}
	$query = "INSERT INTO $table (".implode(", ", $field_names).") VALUES (".implode(", ", $field_values).") ON DUPLICATE KEY UPDATE ".implode(", ", $field)."";
	//$query = "REPLACE INTO $table (".implode(", ", $field_names).") VALUES (".implode(", ", $field_values).")";
	//$query = "INSERT IGNORE INTO $table (".implode(", ", $field_names).") VALUES (".implode(", ", $field_values).")";
	//echo $query."<br/>";
	return $db->ExecSQL($query, true);
}


/* Функция выполняет измененние одной записи в таблице
  $table - имя таблицы
  $fields[]['name']  - имя поля в таблице
  $fields[]['value'] - значение, которое нужно вставить
  $fields[]['type']  - тип поля, значение 'BLOB' должно обрабатываться
                       особым образом
  $pk_name           - Имя поля, явлющегося первичным ключом
  $pk_value          - значение первичного ключа, определяющее запись
*/
function update_record($table, $fields, $pk_name, $pk_value) {
	global $DB;
	$fields_set = "";
	while ($c_field = current($fields)) {
		$c_field['value'] = addslashes($c_field['value']);
		$fields_set .= ", ".$c_field['name']."=";
		if (trim(strtoupper($c_field['type'])) == "DATE") {
			$fields_set .= "'".to_db_date($c_field['value'])."'";
		}
		elseif (trim(strtoupper($c_field['type'])) == "TIMESTAMP") {
			$fields_set .= "'".to_db_timestamp($c_field['value'])."'";
		}
		else {
			$fields_set .= "'".($c_field['value'] == '' && $c_field['default'] != '' ? $c_field['default'] : $c_field['value'])."'";
		}

		next($fields);
	}

	$fields_set = preg_replace("/^, /", "", $fields_set);

	$sql = "UPDATE $table SET $fields_set WHERE $pk_name = '$pk_value'";
//	print $sql;

	return $DB->ExecSQL($sql);
}


/* Функция выполняет измененние одной записи в таблице
  $table - имя таблицы
  $fields[]['name']  - имя поля в таблице
  $fields[]['value'] - значение, которое нужно вставить
  $fields[]['type']  - тип поля из деф-файла
  $pk_fields[]["name"]           - Имя поля, явлющегося первичным ключом
  $pk_fields[]["value"]          - значение первичного ключа, определяющее запись
*/
function update_record_with_type($table, $fields, $pk_fields) {
	global $db;

	$fields_set = array();
	foreach ($fields as $c_field){
		$c_field['value'] = addslashes($c_field['value']);
		if ($c_field['type'] == "integer") $c_field['value'] = intval($c_field['value']);
		if ($c_field['type'] == "float") $c_field['value'] = floatval($c_field['value']);
		if (preg_match("/date/", $c_field['type']) && $c_field['value'] == "") {
			//$fields_set[] = $c_field['name']."='NULL'";
			$field_values[$i] = $c_field['default'];
		}
		else {
			$fields_set[] = $c_field['name']."='".($c_field['value'] == '' && $c_field['default'] != '' ? $c_field['default'] : $c_field['value'])."'";
		}
	}
	
	$pk_string = array();
	if ($pk_fields) foreach ($pk_fields as $pkf) $pk_string[] = "{$pkf["name"]}='{$pkf["value"]}'";
	$query = "UPDATE $table SET ".implode(", ", $fields_set).($pk_string ? " WHERE ".implode(" AND ", $pk_string) : "");
	return $db->ExecSQL($query, true);
}

?>
