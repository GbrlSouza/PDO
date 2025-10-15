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

    public function addPessoa($nome, $email, $telefone): bool {
        $pessoa = $this -> pdo -> prepare("select id from pessoa where email = :email");
        $pessoa -> bindValue(":email", $email);
        $pessoa -> execute();

        if ($pessoa -> rowCount() === 0) {
            $pessoa = $this -> pdo -> prepare("insert into pessoa (nome, email, telefone) values (:nome, :email, :telefone)");
            $pessoa -> bindValue(":nome", $nome);
            $pessoa -> bindValue(":email", $email);
            $pessoa -> bindValue(":telefone", $telefone);
            $pessoa -> execute();
            
            return true;
        } else { return false; }
    }

    public function deletePessoa($id): void {
        $pessoa = $this -> pdo -> prepare("delete from pessoa where id = :id");
        $pessoa -> bindValue(":id", $id);
        $pessoa -> execute();
    }

    public function updatePessoa($id, $nome, $email, $telefone): bool {
        $pessoa = $this -> pdo -> prepare("select id from pessoa where email = :email and id != :id");
        $pessoa -> bindValue(":email", $email);
        $pessoa -> bindValue(":id", $id);
        $pessoa -> execute();

        if ($pessoa -> rowCount() === 0) {
            $pessoa = $this -> pdo -> prepare("update pessoa set nome = :nome, email = :email, telefone = :telefone where id = :id");
            $pessoa -> bindValue(":nome", $nome);
            $pessoa -> bindValue(":email", $email);
            $pessoa -> bindValue(":telefone", $telefone);
            $pessoa -> bindValue(":id", $id);
            $pessoa -> execute();
            
            return true;
        } else { return false; }
    }

    public function searchPessoa($id): array {
        $pessoa = $this -> pdo -> prepare("select * from pessoa where id = :id");
        $pessoa -> bindValue(":id", $id);
        $pessoa -> execute();

        return $pessoa -> fetch(PDO::FETCH_ASSOC);
    }
}
