<?php

class Database {

    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = '';
    private $banco = 'blog_aula';
    private $porta = '3306';
    private $dbh;
    private $stmt;

    public function __construct()
    {
        //fonte de dados ou DSN contém as informações necessárias para conectar ao banco de dados.
        $dsn = 'mysql:host='.$this->host.';port='.$this->porta.';dbname='.$this->banco;
        $opcoes = [
            //armazena em cache a conexão para ser reutilizada, evita a sobrecarga de uma nova conexão, resultando em um aplicativo mais rápido
            PDO::ATTR_PERSISTENT => true,
            //lança uma PDOException se ocorrer um erro 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            //cria a instancia do PDO
            $this->dbh = new PDO($dsn, $this->usuario, $this->senha, $opcoes);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    //Prepared Statements com query
    public function query($sql){
        //prepara uma consulta sql
        $this->stmt = $this->dbh->prepare($sql);
    }

    //vincula um valor a um parâmetro
    public function bind($parametro, $valor, $tipo = null){
        if(is_null($tipo)):
            switch (true):
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                break;
                default:
                $tipo = PDO::PARAM_STR;
            endswitch;
        endif;

        $this->stmt->bindValue($parametro, $valor, $tipo);
    }

    //executa prepared statement
    public function executa(){
        return $this->stmt->execute();
    }

    

}



