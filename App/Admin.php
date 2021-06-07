<?php

namespace App;

use Exception;

class Admin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        session_start();
        $this->checkAdmin();
    }

    public function checkAdmin()
    {
        if (isset($_SESSION["type"]) && $_SESSION["type"] == 'admin') {
            $sql = "SELECT UserType FROM User WHERE Username=:username AND Email=:email LIMIT 1";
            try {
                $stmt = $this->pdo->query($sql);
                $stmt->execute([
                    ':username' => $_SESSION['username'],
                    ':email' => $_SESSION['email'],
                ]);

                $result = $stmt->fetchAll();
                if (!$result)
                    header("Location: index.php");
            } catch (Exception $e) {
                echo 'You do not have validated!!';
                header("Location: index.php");
            }
        } else {
            echo 'You not have permission to access this page!!';
            header("Location: index.php");
        }
    }

    public function Question()
    {
        $sql = "SELECT * FROM Question";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function DeleteQuestion($id)
    {
        try {
            $sql = "Delete FROM Question WHERE ID=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return "Success To Delete";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function Report()
    {
        $sql = "SELECT * FROM Report";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function DeleteReport($id)
    {
        try {
            $sql = "Delete FROM Report WHERE ID=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $id,
            ]);
            return "Success To Delete";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CreateQuestion(
        $title,
        $description,
        $type_question,
        $point_question,
        $answer_A,
        $answer_B,
        $answer_C,
        $answer_D,
        $result
    ) {
        $sql = "INSERT INTO Question(title, description, ans_a, ans_b, ans_c, ans_d, result, point, typequestion) 
        VALUES(:title, :description, :ans_a, :ans_b, :ans_c, :ans_d, :result, :point, :type_question)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':type_question' => $type_question,
                ':point' => $point_question,
                ':ans_a' => $answer_A,
                ':ans_b' => $answer_B,
                ':ans_c' => $answer_C,
                ':ans_d' => $answer_D,
                ':result' => $result,
            ]);
            return "Success To Add";
        } catch (Exception $e) {
            //echo $sql . $e->getMessage();
            return "Fail To Add";
        }
    }
}
