<?php
$databasehost = "localhost"; 	// Database Host
$databasename = ""; 			// Database name
$databasetable = ""; 			// Table name
$databaseusername="root"; 		// Database user username
$databasepassword = ""; 		// Database user password
$fieldseparator = ","; 
$lineseparator = "\n";
$csvfile = "file.csv";

if(!file_exists($csvfile)) {
    die("File not found. Make sure you specified the correct path.");
}

try {
    $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
        $databaseusername, $databasepassword,
        array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
} catch (PDOException $e) {
    die("database connection failed: ".$e->getMessage());
}

$affectedRows = $pdo->exec("
    LOAD DATA LOCAL INFILE ".$pdo->quote($csvfile)." INTO TABLE `$databasetable`
    FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
    LINES TERMINATED BY ".$pdo->quote($lineseparator));

echo "Loaded a total of $affectedRows records from this csv file.\n";

?>
