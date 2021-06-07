<?php

namespace App;

use Exception;

class Users
{
    private $pdo;

    public function __construct($pdo)
    {
        //session_start();
        $this->pdo = $pdo;
        $this->checkLogin();
    }

    public function checkLogin()
    {
        if (isset($_SESSION["type"]) && ($_SESSION["type"] == 'user' || ($_SESSION["type"] == 'admin'))) {
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
            //header("Location: index.php");
        } else {
            echo 'You not have permission to access this page!!';
            header("Location: index.php");
        }
    }

    // Get Data From Table User
    //     public function AllUser() {
    //         $stmt = $this->pdo->query('SELECT * FROM User');
    //         $tables = [];
    //         while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    //             $tables[] = $row;
    //         }
    //         return $tables;
    //     }

    //     public function CreateUser($username, $email, $password, $re_password) {
    //        if(empty($username) || empty($email) || empty($password) || empty($re_password)) {
    //            die("Error: You must be enter all field.");
    //        }
    //
    //         $sql = $this->pdo->query('INSERT INTO User(Username, Password, Email) '.
    //             'VALUES(:Username,:Password, :Email)');
    //
    //         $stmt  = $this->pdo->prepare($sql);
    //         $stmt->execute([
    //             ':Username' => $username,
    //             ':Email' => $email,
    //             ':Password' => $password
    //         ]);
    //
    //         return $this->pdo->lastInsertId();
    //     }
    public function CreateUser($username, $email, $password, $re_password)
    {
        //         $safePost = filter_input_array(INPUT_POST, [
        //             $username => FILTER_SANITIZE_STRING,
        //             $password => FILTER_SANITIZE_STRING,
        //             $re_password => FILTER_SANITIZE_STRING,
        //             $email => FILTER_SANITIZE_STRING,
        //         ]);


        if (empty($username) || empty($email) || empty($password) || empty($re_password))
            return "Value Cannot Be Empty!!";
        if ($password != $re_password)
            return "Password does not matches!!";

        $sql = 'INSERT INTO User(Username, Password, Email) VALUES(:username, :password, :email)';

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':password' => $password,
                ':email' => $email,
            ]);

            header("Location: test.php");
            return "Success To Add";
        } catch (Exception $e) {
            //echo $sql . $e->getMessage();
            header("Location: register.php");
            return "Fail To Add";
        }
    }

    public function Login($username, $password)
    {
        if (empty($username) || empty($password))
            return "Value Cannot Be Empty!!";
        $sql = "SELECT Username, Email, UserType FROM User WHERE Username=:username AND Password=:password LIMIT 1";

        try {
            $stmt = $this->pdo->query($sql);
            $stmt->execute([
                ':username' => $username,
                ':password' => $password,
            ]);

            $result = $stmt->fetchAll();
            if ($result != null) {
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $result[0]['Email'];
                $_SESSION["type"] = $result[0]['UserType'];

                if ($result[0]['UserType'] == 'admin')
                    header("Location: admin.php");
                else if ($result[0]['UserType'] == 'user')
                    header("Location: index.php");
                else header("Location: login.php");
            } else header("Location: login.php");
        } catch (Exception $e) {
            //echo $sql . $e->getMessage();
            //header("Refresh:0; url=register.php");
            header("Location: login.php");
        }
    }
    public function Question()
    {
        $sql = "SELECT * FROM Question ORDER BY RANDOM() LIMIT 20";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function SubmitQuestion($request, $mssv, $name, $email)
    {
        try {
            $correct = 0;
            $point = 0;
            foreach ($request as $key => $value) {
                if (str_contains($key, 'result')) {
                    $id_question = substr($key, 6);

                    $sql = "SELECT Result, Point FROM Question Where Id=:id_question";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([":id_question" => $id_question]);
                    $res = $stmt->fetch(\PDO::FETCH_ASSOC);

                    if ($res['Result'] == $value . ' ') {
                        $correct++;
                        $point = $point + $res['Point'];
                    }
                }
            }

            $sql_insert = "INSERT INTO Report(Mssv, Name, Email, Final_Result, Point) VALUES (:mssv, :name, :email, :final_result, :point)";
            $statement = $this->pdo->prepare($sql_insert);
            $statement->execute([
                ':mssv' => $mssv,
                ':name' => $name,
                ':email' => $email,
                ':final_result' => $correct . '/20',
                ':point' => $point,
            ]);

            return $correct . '/20';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
