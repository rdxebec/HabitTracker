
<?php 
class Database{
    private static $instance = null;
    private $connection ;

    private function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';

        try{
            $this ->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config["username"],
                $config["password"]
            );
            $this ->connection ->setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
            );
        }catch( PDOException $e){
            die("Datbase Connection Failed: ".$e->getMessage() );
        }
    }
    public static function getInstance()
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        return $this ->connection;
    }
}
?>