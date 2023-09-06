<?php
session_start();
spl_autoload_register();
require_once "config/config.php";
error_reporting(-1);


// ОТПРАВКА ПЕРВОЙ ФОРМЫ

if (isset($_POST["newstudent"])) 
{
    $add = new classes\database;
    $add->insert_student($_POST['name'], $_POST['lastname'], $_POST['sex'], $_POST['email'], $_POST['score'], $_POST['birthday'], $_POST['place'], $pdo);
}


// ОТПРАВКА ВТОРОЙ ФОРМЫ

if (isset($_POST['change'])) 
{
    $change = new classes\database;
    $change->update_student($_POST, $_SESSION['auth'], $pdo);
} 


// ВЫХОД ПОЛЬЗОВАТЕЛЯ ИЗ ВТОРОЙ ФОРМЫ

if (isset($_GET['do'])) 
{
    session_destroy();
    header("Location:index.php");
    die();
}

if (!isset($_SESSION['auth']) && empty($_SESSION['auth'])) : ?>                      <!--  1. ФОРМА ВВОДА ДАННЫХ  -->
    <div class="mainform">
        <form action="" method="post">
            <p>Имя: <input type="text" name="name"></p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_name"])) {
                            echo $_SESSION["error_name"];
                            unset($_SESSION["error_name"]);
                        }
                    ?>
            </div>
            <p>Фамилия: <input type="text" name="lastname"></p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_lastname"])) {
                            echo $_SESSION["error_lastname"];
                            unset($_SESSION["error_lastname"]);
                        }
                    ?>
            </div>
            <p>Пол:</p>
            <p><input type="hidden" name="sex" value="null"></p>
            <p><input type="radio" name="sex" value="woman"> Женский</p>
            <p><input type="radio" name="sex" value="man"> Мужской</p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_sex"])) {
                            echo $_SESSION["error_sex"];
                            unset($_SESSION["error_sex"]);
                        }
                    ?>
            </div>
            <p>E-mail: <input type="text" name="email"></p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_email"])) {
                            echo $_SESSION["error_email"];
                            unset($_SESSION["error_email"]);
                        }
                    ?>
            </div>
            <p>Общее кол-во баллов: <input type="number" name="score"></p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_score"])) {
                            echo $_SESSION["error_score"];
                            unset($_SESSION["error_score"]);
                        }
                    ?>
            </div>
            <p>Дата рождения: <input type="date" name="birthday"></p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_birthday"])) {
                            echo $_SESSION["error_birthday"];
                            unset($_SESSION["error_birthday"]);
                        }
                    ?>
            </div>
            <p>Откуда вы?</p>
            <p><input type="hidden" name="place" value="null"></p>
            <p><input type="radio" name="place" value="local"> Местный</p>
            <p><input type="radio" name="place" value="nonresident"> Иногородний</p>
            <div class="flash">
                    <?php 
                        if (isset($_SESSION["error_place"])) {
                            echo $_SESSION["error_place"];
                            unset($_SESSION["error_place"]);
                        }
                    ?>
            </div>
            <p><input type="submit" name="newstudent"></p>
        </form>
    </div>
    
<?php else : ?>
    <div class="changeform">                                                      <!-- 2. ФОРМА РЕДАКТИРОВАНИЯ ДАННЫХ  -->
        <div class="success">
            <?php 
                if (isset($_SESSION["success"])) {
                    echo $_SESSION["success"];
                    unset($_SESSION["success"]);
                }
            ?>
        </div>
        <div class="container">
            <div class="name">
                Ваше имя: <?php echo $_SESSION['name']?>                           <!-- 2.1 РЕДАКТИРОВАНИЕ ИМЕНИ -->
                <div class="change">
                    Изменить имя:
                    <form action="" method="post">
                        <input type="text" name="newname">
                        <input type="submit" name="change" value="Сохранить">
                    </form>
                    <?php 
                        if (isset($_SESSION["error_name"])) {
                            echo $_SESSION["error_name"];
                            unset($_SESSION["error_name"]);
                        }
                    ?>
                </div>
            </div>
            <div class="lastname"> 
                Ваша фамилия: <? echo $_SESSION['lastname']?>                       <!-- 2.2 РЕДАКТИРОВАНИЕ ФАМИЛИИ -->
                <div class="change">
                    Изменить фамилию:
                    <form action="" method="post">
                        <input type="text" name="newlastname">
                        <input type="submit" name="change" value="Сохранить">
                    </form>
                    <?php 
                        if (isset($_SESSION["error_lastname"])) {
                            echo $_SESSION["error_lastname"];
                            unset($_SESSION["error_lastname"]);
                        }
                    ?>
                </div>
            </div>
            <div class="sex"> 
                Ваш пол:                                                            <!-- 2.3 РЕДАКТИРОВАНИЕ ПОЛА -->
                <? 
                if ($_SESSION['sex'] == "man") {
                    echo "Мужской";
                } else {
                    echo "Женский";
                }
                ?> 
                <div class="change">
                    Изменить пол:
                    <form action="" method="post">
                        <input type="hidden" name="newsex" value="null">
                        <p><input type="radio" name="newsex" value="man"> Мужской</p>
                        <p><input type="radio" name="newsex" value="woman"> Женский</p>
                        <p><input type="submit" name="change" value="Сохранить"></p>
                    </form>
                    <?php 
                        if (isset($_SESSION["error_sex"])) {
                            echo $_SESSION["error_sex"];
                            unset($_SESSION["error_sex"]);
                        }
                    ?>
                </div>
            </div>
            <div class="email"> 
                Ваш E-mail: <? echo $_SESSION['email']?>                            <!-- 2.4 РЕДАКТИРОВАНИЕ E-mail -->
                <div class="change">
                    Изменить E-mail:
                    <form action="" method="post">
                        <input type="text" name="newemail">
                        <input type="submit" name="change" value="Сохранить">
                    </form>
                    <?php 
                        if (isset($_SESSION["error_email"])) {
                            echo $_SESSION["error_email"];
                            unset($_SESSION["error_email"]);
                        }
                    ?>
                </div>
            </div>
            <div class="score"> 
                Ваши баллы: <? echo $_SESSION['score']?></div>                     <!-- 2.5 РЕДАКТИРОВАНИЕ БАЛЛОВ -->
                <div class="change">
                    Изменить кол-во баллов:
                    <form action="" method="post">
                        <input type="number" name="newscore">
                        <input type="submit" name="change" value="Сохранить">
                    </form>
                    <?php 
                        if (isset($_SESSION["error_score"])) {
                            echo $_SESSION["error_score"];
                            unset($_SESSION["error_score"]);
                        }
                    ?>
                </div>
            <div class="birthday">
                 Ваша дата рождения: <? echo $_SESSION['birthday']?>              <!-- 2.6 РЕДАКТИРОВАНИЕ ДАТЫ РОЖДЕНИЯ -->
                 <div class="change">
                    Изменить дату рождения:
                    <form action="" method="post">
                        <input type="date" name="newbirthday">
                        <input type="submit" name="change" value="Сохранить">
                    </form>
                    <?php 
                        if (isset($_SESSION["error_birthday"])) {
                            echo $_SESSION["error_birthday"];
                            unset($_SESSION["error_birthday"]);
                        }
                    ?>
                 </div>
                </div>
            <div class="place"> 
                Ваше местоположение: <? echo $_SESSION['place']?>                 <!-- 2.7 РЕДАКТИРОВАНИЕ МЕСТОПОЛОЖЕНИЯ -->
                <div class="change">
                    Изменить местоположение:
                    <form action="" method="post">
                        <p><input type="hidden" name="newplace" value="null"></p>
                        <p><input type="radio" name="newplace" value="local"> Местный</p>
                        <p><input type="radio" name="newplace" value="nonresident"> Иногородний</p>
                        <input type="submit" name="change" value="Сохранить">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="links">                                                          <!-- 3. ССЫЛКИ -->
        <div class="table">
            <a href="list.php">Список абитуриентов</a>
        </div>
        <div class="exit">
            <a href="?do=exit">Выйти</a>
        </div>
    </div>
<?php endif; ?>
