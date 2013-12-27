<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'arturobecerra';
$active_record = TRUE;

$db['arturobecerra']['hostname'] = 'localhost';
$db['arturobecerra']['username'] = 'cherra';
$db['arturobecerra']['password'] = 'cherra3003';
$db['arturobecerra']['database'] = 'ArturoBecerra';
$db['arturobecerra']['dbdriver'] = 'mysql';
$db['arturobecerra']['dbprefix'] = '';
$db['arturobecerra']['pconnect'] = TRUE;
$db['arturobecerra']['db_debug'] = TRUE;
$db['arturobecerra']['cache_on'] = FALSE;
$db['arturobecerra']['cachedir'] = '';
$db['arturobecerra']['char_set'] = 'utf8';
$db['arturobecerra']['dbcollat'] = 'utf8_general_ci';
$db['arturobecerra']['swap_pre'] = '';
$db['arturobecerra']['autoinit'] = TRUE;
$db['arturobecerra']['stricton'] = FALSE;

$db['constitucion']['hostname'] = 'localhost';
$db['constitucion']['username'] = 'cherra';
$db['constitucion']['password'] = 'cherra3003';
$db['constitucion']['database'] = 'Constitucion';
$db['constitucion']['dbdriver'] = 'mysql';
$db['constitucion']['dbprefix'] = '';
$db['constitucion']['pconnect'] = TRUE;
$db['constitucion']['db_debug'] = TRUE;
$db['constitucion']['cache_on'] = FALSE;
$db['constitucion']['cachedir'] = '';
$db['constitucion']['char_set'] = 'utf8';
$db['constitucion']['dbcollat'] = 'utf8_general_ci';
$db['constitucion']['swap_pre'] = '';
$db['constitucion']['autoinit'] = TRUE;
$db['constitucion']['stricton'] = FALSE;

$db['ayuntamiento']['hostname'] = 'localhost';
$db['ayuntamiento']['username'] = 'cherra';
$db['ayuntamiento']['password'] = 'cherra3003';
$db['ayuntamiento']['database'] = 'Villa';
$db['ayuntamiento']['dbdriver'] = 'mysql';
$db['ayuntamiento']['dbprefix'] = '';
$db['ayuntamiento']['pconnect'] = TRUE;
$db['ayuntamiento']['db_debug'] = TRUE;
$db['ayuntamiento']['cache_on'] = FALSE;
$db['ayuntamiento']['cachedir'] = '';
$db['ayuntamiento']['char_set'] = 'utf8';
$db['ayuntamiento']['dbcollat'] = 'utf8_general_ci';
$db['ayuntamiento']['swap_pre'] = '';
$db['ayuntamiento']['autoinit'] = TRUE;
$db['ayuntamiento']['stricton'] = FALSE;

$db['tecoman']['hostname'] = 'localhost';
$db['tecoman']['username'] = 'cherra';
$db['tecoman']['password'] = 'cherra3003';
$db['tecoman']['database'] = 'Tecoman';
$db['tecoman']['dbdriver'] = 'mysql';
$db['tecoman']['dbprefix'] = '';
$db['tecoman']['pconnect'] = TRUE;
$db['tecoman']['db_debug'] = TRUE;
$db['tecoman']['cache_on'] = FALSE;
$db['tecoman']['cachedir'] = '';
$db['tecoman']['char_set'] = 'utf8';
$db['tecoman']['dbcollat'] = 'utf8_general_ci';
$db['tecoman']['swap_pre'] = '';
$db['tecoman']['autoinit'] = TRUE;
$db['tecoman']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */