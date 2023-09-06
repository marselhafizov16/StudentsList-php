<?php
namespace classes;

use PDO;

class database {

    public function insert_student($name, $lastname, $sex, $email, $score, $birthday, $place, $pdo) 
    {
        if (empty(trim(strval($name)))) {
            $_SESSION["error_name"] = "Имя должно быть заполнено!";
            return false;
        } elseif (empty(trim(strval($lastname)))) {
            $_SESSION["error_lastname"] = "Фамилия должна быть заполнена!";
            return false;
        } elseif ($sex == "null") {
            $_SESSION["error_sex"] = "Нужно выбрать пол!";
            return false;
        } elseif (empty(trim($email))) {
            $_SESSION["error_email"] = "Нужно ввести E-mail!";
            return false;
        } elseif (empty($score)) {
            $_SESSION["error_score"] = "Введите кол-во баллов!";
            return false;
        } elseif ($score <= 88 || $score >= 300) {
            $_SESSION['error_score'] = 'Введено некорректное значение!';
            return false;
        } elseif (empty(trim($birthday))) {
            $_SESSION["error_birthday"] = "Введите вашу дату рождения!";
            return false;
        } elseif ($place == "null") {
            $_SESSION["error_place"] = "Выбери, откуда вы!";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_email'] = 'Некорректный E-mail!';
            return false;
        }
        
        $email_result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
        $row = $email_result->fetch();

        if (!empty($row)) {
            $_SESSION['error_email'] = 'Пользователь с таким E-mail уже существует!';
            return false;
        }

        $pdo->exec("INSERT INTO Students (name, lastname, sex, email, score, birthday, place) VALUES ('$name', '$lastname', '$sex', '$email', '$score', '$birthday', '$place')");
        $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
        $row = $result->fetch();
        $_SESSION['auth'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['sex'] = $row['sex'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['score'] = $row['score'];
        $_SESSION['birthday'] = $row['birthday'];
        $_SESSION['place'] = $row['place'];
        $_SESSION['success'] = 'Cпасибо, данные сохранены, вы можете при желании их отредактировать';
    }

    public function update_student($arr, $email, $pdo) 
    {

        if (isset($arr['newname'])) {
            if (empty(trim($arr['newname']))) {
                $_SESSION["error_name"] = "Имя должно быть заполнено!";
                return false;
            }

            $newname = $arr['newname'];
            $name = $pdo->exec(" UPDATE `students` SET `name`='$newname' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['name'] = $row['name'];
        }

        if (isset($arr['newlastname'])) {
            if (empty(trim($arr['newlastname']))) {
                $_SESSION["error_lastname"] = "Фамилия должна быть заполнена!";
                return false;
            }

            $newlastname = $arr['newlastname'];
            $lastname = $pdo->exec(" UPDATE `students` SET `lastname`='$newlastname' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['lastname'] = $row['lastname'];
        }

        if (isset($arr['newsex'])) {
            $newsex = $arr['newsex'];
            if ($newsex == "null") {
                $_SESSION["error_sex"] = "Нужно выбрать пол!";
                return false;
            }
            
            $sex = $pdo->exec(" UPDATE `students` SET `sex`='$newsex' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['sex'] = $row['sex'];
        }

        if (isset($arr['newemail'])) {
            $newemail = $arr['newemail'];
            if (empty(trim($newemail))) {
                $_SESSION["error_email"] = "Нужно ввести E-mail!";
                return false;
            }

            if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_email'] = 'Некорректный E-mail!';
                return false;
            }

            $mail = $pdo->exec(" UPDATE `students` SET `email`='$newemail' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['auth'] = $row['email'];
            $_SESSION['email'] = $row['email'];
        }

        if (isset($arr['newscore'])) {
            $newscore = $arr['newscore'];
            if (empty($newscore)) {
                $_SESSION["error_score"] = "Введите кол-во баллов!";
                return false;
            } elseif ($newscore <= 88 || $newscore >= 300) {
                $_SESSION['error_score'] = 'Введено некорректное значение!';
                return false;
            }

            $score = $pdo->exec(" UPDATE `students` SET `score`='$newscore' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['score'] = $row['score'];
        }

        if (isset($arr['newbirthday'])) {
            $newbirthday = $arr['newbirthday'];
            if (empty(trim($newbirthday))) {
                $_SESSION["error_birthday"] = "Введите вашу дату рождения!";
                return false;
            }

            $birthday = $pdo->exec(" UPDATE `students` SET `birthday`='$newbirthday' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['birthday'] = $row['birthday'];
        }

        if (isset($arr['newplace'])) {
            $newplace = $arr['newplace'];
            if ($newplace == "null") {
                $_SESSION["error_place"] = "Выберите, откуда вы!";
                return false;
            }

            $birthday = $pdo->exec(" UPDATE `students` SET `place`='$newplace' WHERE email='$email' ");
            $result = $pdo->query("SELECT * FROM students WHERE email='$email' ");
            $row = $result->fetch();
            $_SESSION['place'] = $row['place'];
        }

    }

    public function all_list($pdo) 
    {
        $select = $pdo->query("SELECT name, lastname, score FROM `students`");
        return $select;
    }

    public function search_student($search, $pdo)
    {
        $arr = explode(' ', $search);
        if (count($arr) == 1) {
            $select = $pdo->query("SELECT name, lastname, score FROM `students` WHERE name LIKE '%$search%' or lastname LIKE '%$search%'");
            return $select;
            
        } elseif (count($arr) == 2) {
            $select = $pdo->query("SELECT name, lastname, score FROM `students` WHERE name LIKE '%$arr[0]%' and lastname LIKE '%$arr[1]%'");
            return $select;
        }
    }
}

