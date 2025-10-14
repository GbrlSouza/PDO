<?php
Class Pessoa {
    private $pdo;

    public function __construct($dbname, $host, $user, $pass) {
        try { $this -> pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $pass); }
        catch (PDOException $e) {
            echo "Erro com banco de dados: " . $e -> getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro genérico: ". $e -> getMessage();
            exit();
        }
    }

    public function getPessoa(): array {
        $pessoas = $this -> pdo -> query("SELECT * FROM pessoa");

        if ($pessoas === false) { return []; }
        return $pessoas -> fetchAll(PDO::FETCH_ASSOC);
    }
}
