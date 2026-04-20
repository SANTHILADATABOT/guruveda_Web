<?php 
/*
* This file contains the Backup_Database class which performs
* a partial or complete backup of any given MySQL database
* @author Daniel López Azaña <-->
* @version 1.0
* Updated for PHP 8.4 compatibility
*/

// Report all errors

error_reporting(E_ALL);

/*
* Define database parameters here
*/

require("../model/config.inc.php");

define("DB_USER", DB_USER);
define("DB_PASSWORD", DB_PASS);
define("DB_NAME", DB_DATABASE);
define("DB_HOST", DB_SERVER);
define("OUTPUT_DIR", dirname(__DIR__).'/backup');
define("TABLES", '*');

/*
* Instantiate Backup_Database and perform backup
*/

$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$status = $backupDatabase->backupTables(TABLES, OUTPUT_DIR) ? 'OK' : 'KO';
echo "Backup result: ".$status;

/*
* The Backup_Database class
*/

class Backup_Database
{
	/*
    * Host where database is located
    */
    private string $host = '';

    /*
    * Username used to connect to database
    */
    private string $username = '';

    /*
    * Password used to connect to database
    */
    private string $passwd = '';

    /*
    * Database to backup
    */
    private string $dbName = '';

    /*
    * Database charset
    */
    private string $charset = '';

    /*
    * MySQLi connection
    */
    private ?mysqli $conn = null;

    /*
    * Constructor initializes database
    */
    public function __construct(string $host, string $username, string $passwd, string $dbName, string $charset = 'utf8')
    {
    	$this->host     = $host;
        $this->username = $username;
        $this->passwd   = $passwd;
        $this->dbName   = $dbName;
        $this->charset  = $charset;
        $this->initializeDatabase();
    }

    protected function initializeDatabase(): void
    {
    	$this->conn = new mysqli($this->host, $this->username, $this->passwd, $this->dbName);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        if (!$this->conn->set_charset($this->charset))
        {
        	$this->conn->query('SET NAMES '.$this->charset);
        }
    }

    /*
    * Backup the whole database or just some tables
    * Use '*' for whole database or 'table1 table2 table3...'
    * @param string $tables
    */
    public function backupTables(string $tables = '*', string $outputDir = '.'): bool
    {
        try
        {
            /*
            * Tables to export
            */
            if($tables == '*')
            {
                $tables = [];
                $result = $this->conn->query('SHOW TABLES');
                if($result) {
                    while($row = $result->fetch_row())
                    {
                        $tables[] = $row[0];
                    }
                    $result->free();
                }
            }
            else
            {
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }

            $sql = 'CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n\n";
            $sql .= 'USE '.$this->dbName.";\n\n";

            /*
            * Iterate tables
            */
            foreach($tables as $table)
            {
               // echo "Backing up ".$table." table...";
                $result = $this->conn->query('SELECT * FROM '.$table);
                if(!$result) continue;
                
                $numFields = $result->field_count;

                $sql .= 'DROP TABLE IF EXISTS '.$table.';';
                $result2 = $this->conn->query('SHOW CREATE TABLE '.$table);
                if($result2) {
                    $row2 = $result2->fetch_row();
                    $sql.= "\n\n".$row2[1].";\n\n";
                    $result2->free();
                }

                while($row = $result->fetch_row())
                {
                    $sql .= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$numFields; $j++) 
                    {
                        $row[$j] = addslashes($row[$j] ?? '');
                        //$row[$j] = preg_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j]))
                        {
                            $sql .= '"'.$row[$j].'"' ;
                        }
                        else
                        {
                            $sql.= '""';
                        }

                        if ($j < ($numFields-1))
                        {
                            $sql .= ',';
                        }
                    }

                    $sql.= ");\n";
                }
                $result->free();

                $sql.="\n\n\n";
              	//echo " OK" . "";
            }
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }
        return $this->saveFile($sql, $outputDir);
    }

    /*
    * Save SQL to file
    * @param string $sql
    */
    protected function saveFile(string &$sql, string $outputDir = '.'): bool
    {
        if (!$sql) return false;

        try
        {
            if(!is_dir($outputDir.'/dump')) {
                mkdir($outputDir.'/dump', 0755, true);
            }
            $handle = fopen($outputDir.'/dump/'.$this->dbName.' - '.date("d-m-Y h.i a", time()).'.sql','w+');
            if($handle) {
                fwrite($handle, $sql);
                fclose($handle);
            } else {
                return false;
            }
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }

    public function __destruct()
    {
        if($this->conn) {
            $this->conn->close();
        }
    }
}?>
