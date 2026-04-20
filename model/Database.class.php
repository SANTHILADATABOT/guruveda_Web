<?php
# Name: Database.class.php
# File Description: MySQL Class to allow easy and clean access to common mysql commands
# Author: ricocheting
# Web: http://www.ricocheting.com/
# Update: 2010-05-08
# Version: 2.2.5
# Copyright 2003 ricocheting.com
# Updated for PHP 8.4 compatibility


/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/



//require("config.inc.php");
//$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);


###################################################################################################
###################################################################################################
###################################################################################################
class Database {


private string $server   = ""; //database server
private string $user     = ""; //database login name
private string $pass     = ""; //database login password
private string $database = ""; //database name
private string $pre      = ""; //table prefix


#######################
//internal info
public string $error = "";
public int $errno = 0;

//number of rows affected by SQL query
public int $affected_rows = 0;

public ?mysqli $link_id = null;
public $query_id = null; // mysqli_result or null


#-#############################################
# desc: constructor
public function __construct(string $server, string $user, string $pass, string $database, string $pre=''){
	$this->server=$server;
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
	$this->pre=$pre;
}#-#constructor()


#-#############################################
# desc: connect and select database using vars above
# Param: $new_link can force connect() to open a new link, even if mysqli_connect() was called before with the same parameters
public function connect(bool $new_link=false): bool {
	$this->link_id = @new mysqli($this->server, $this->user, $this->pass, $this->database);

	if ($this->link_id->connect_error) {//open failed
		$this->oops("Could not connect to server: <b>{$this->server}</b>.");
		return false;
	}

	// unset the data so it can't be dumped
	$this->server='';
	$this->user='';
	$this->pass='';
	$this->database='';
	
	return true;
}#-#connect()


#-#############################################
# desc: close the connection
public function close(): bool {
	if($this->link_id && !@$this->link_id->close()){
		$this->oops("Connection close failed.");
		return false;
	}
	return true;
}#-#close()


#-#############################################
# Desc: escapes characters to be mysql ready
# Param: string
# returns: string
public function escape(string $string): string {
	return $this->link_id->real_escape_string($string);
}#-#escape()


#-#############################################
# Desc: executes SQL query to an open connection
# Param: (MySQL query) to execute
# returns: (query_id) for fetching results etc
public function query(string $sql): mixed {
	// do query
	$this->query_id = @$this->link_id->query($sql);

	if (!$this->query_id) {
		$this->oops("<b>MySQL Query fail:</b> $sql");
		return 0;
	}
	
	$this->affected_rows = $this->link_id->affected_rows;

	return $this->query_id;
}#-#query()


#-#############################################
# desc: fetches and returns results one line at a time
# param: query_id for mysql run. if none specified, last used
# return: (array) fetched record(s)
public function fetch_array($query_id = -1): ?array {
	// retrieve row
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}

	if (isset($this->query_id) && $this->query_id instanceof mysqli_result) {
		$record = @$this->query_id->fetch_assoc();
	}else{
		$this->oops("Invalid query_id: <b>{$this->query_id}</b>. Records could not be fetched.");
		return null;
	}

	return $record;
}#-#fetch_array()


#-#############################################
# desc: returns all the results (not one row)
# param: (MySQL query) the query to run on server
# returns: assoc array of ALL fetched results
public function fetch_all_array(string $sql): array {
	$query_id = $this->query($sql);
	$out = [];

	while ($row = $this->fetch_array($query_id)){
		$out[] = $row;
	}

	$this->free_result($query_id);
	return $out;
}#-#fetch_all_array()


#-#############################################
# desc: frees the resultset
# param: query_id for mysql run. if none specified, last used
public function free_result($query_id=-1): void {
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}
	if($this->query_id && $this->query_id instanceof mysqli_result) {
		@$this->query_id->free();
	}
}#-#free_result()


#-#############################################
# desc: does a query, fetches the first row only, frees resultset
# param: (MySQL query) the query to run on server
# returns: array of fetched results
public function query_first(string $query_string): ?array {
	$query_id = $this->query($query_string);
	$out = $this->fetch_array($query_id);
	$this->free_result($query_id);
	return $out;
}#-#query_first()

public function query_delete(string $table, string $where='1'): mixed {
	$q="DELETE FROM `".$this->pre.$table."`";

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $this->query($q);
}#-#query_delete()

#-#############################################
# desc: does an update query with an array
# param: table (no prefix), assoc array with data (doesn't need escaped), where condition
# returns: (query_id) for fetching results etc
public function query_update(string $table, array $data, string $where='1'): mixed {
	$q="UPDATE `".$this->pre.$table."` SET ";

	foreach($data as $key=>$val) {
		if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
		elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
        elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + {$m[1]}, "; 
		else $q.= "`$key`='".$this->escape($val)."', ";
	}

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $this->query($q);
}#-#query_update()


#-#############################################
# desc: does an insert query with an array
# param: table (no prefix), assoc array with data
# returns: id of inserted record, false if error
public function query_insert(string $table, array $data): mixed {
	$q="INSERT INTO `".$this->pre.$table."` ";
	$v=''; $n='';

	foreach($data as $key=>$val) {
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->escape($val)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	if($this->query($q)){
		//$this->free_result();
		return $this->link_id->insert_id;
	}
	else return false;

}#-#query_insert()


#-#############################################
# desc: throw an error message
# param: [optional] any custom error to display
public function oops(string $msg=''): void {
	if($this->link_id && $this->link_id->connect_errno > 0){
		$this->error=$this->link_id->connect_error;
		$this->errno=$this->link_id->connect_errno;
	}
	elseif($this->link_id){
		$this->error=$this->link_id->error;
		$this->errno=$this->link_id->errno;
	}
	else{
		$this->error="No database connection";
		$this->errno=0;
	}
	?>
		<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
		<tr><th colspan=2>Database Error</th></tr>
		<tr><td align="right" valign="top">Message:</td><td><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></td></tr>
		<?php if(!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>'.htmlspecialchars($this->error, ENT_QUOTES).'</td></tr>'; ?>
		<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
		<?php if(!empty($_SERVER['REQUEST_URI'])) echo '<tr><td align="right">Script:</td><td><a href="'.htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES).'">'.htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES).'</a></td></tr>'; ?>
		<?php if(!empty($_SERVER['HTTP_REFERER'])) echo '<tr><td align="right">Referer:</td><td><a href="'.htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES).'">'.htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES).'</a></td></tr>'; ?>
		</table>
	<?php
}#-#oops()


}//CLASS Database
###################################################################################################

?>
