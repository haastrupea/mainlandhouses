<?php
class database{
    /**
     * store instance of the current database connection
     */
    private $_dbcon;
    private $_dbName;
    static private $_instance=[];

    static public function getInstance($dbdriver,$dbname,$usr=null,$psw=null)
    {
        if(empty(self::$_instance)){
            self::$_instance[$dbname]= new self($dbdriver,$dbname,$usr,$psw);
        }else{
            if(!array_key_exists($dbname,self::$_instance)){
            self::$_instance[$dbname]= new self($dbdriver,$dbname,$usr,$psw);
            }
        }
        return self::$_instance[$dbname];
    }

    private function __construct($dbdriver,$dbname,$usr,$psw)
    {
        $this->_dbName=$dbname;
        $dsn='';
        switch (strtolower($dbdriver)) {
            case 'mysql':
                $dsn="mysql:host=127.0.0.1;dbname={$dbname};charset=utf8";
                break;
                case 'sqlite':
                $dsn="sqlite:{$dbname}";
                break;
        }
            $dbcon=new \PDO($dsn,$usr,$psw);
            $this->_dbcon=$dbcon;
    }

    public function __clone(){}

    public function getConnection()
    {
        //to perform non crud operation
            return $this->_dbcon;
    }

    private function queryDb($query,array $param=null,$getresult=true,$fetchStyle=\PDO::FETCH_ASSOC)
    {    
        $qry=$this->_dbcon->prepare($query);
        $satus=is_null($param)?$qry->execute(): $qry->execute($param);
        //return result
        if ($getresult) {
            return $satus?$qry->fetchAll($fetchStyle):false;   
        }
    }
    
    public function crudQuery($qry,array $param=null,$fetchStyle=\PDO::FETCH_ASSOC)
    {    
        $selectQry=stripos($qry,"select");
        return !is_bool($selectQry)?$this->queryDb($qry,$param,true,$fetchStyle):$this->queryDb($qry,$param,false);
    }
}