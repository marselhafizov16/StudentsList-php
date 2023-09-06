<?php
spl_autoload_register();
require_once "config/config.php";
session_start();

// 1. Вывод всех пользователей таблицы
$sel = new classes\Database;
$res = $sel->all_list($pdo);

if (isset($_GET['search'])) 
{
    $search = new classes\Database;
    $result_search = $search->search_student($_GET['search'], $pdo);
}

if (isset($_GET['do'])) 
{
    session_destroy();
    header("Location:index.php");
    die();
}


if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])) :?>
    <div class="search">
        <p><b>Поиск абитуриентов:</b></p>
        <form action="" method="get">
            Поиск: <input type="text" name="search">
            <input type="submit">
            <p>Поиск осуществляется в формате "Имя", "Фамилия" или "Имя Фамилия"</p>
        </form>
    </div>
    <?php if (!isset($_GET['search'])) : ?>
        <div class="list">
            <p><b>Общий список абитуриентов:</b></p>
            <table>
                <tr>
                    <th>Имя</th><th>Фамилия</th><th>Количество баллов</th>
                </tr>
                <?php
                    foreach ($res as $arr) {
                        echo "<tr>";
                            echo "<td>{$arr['name']}</td><td>{$arr['lastname']}</td><td>{$arr['score']}</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <div class="links">
            <p><a href="index.php">К настройкам профиля</a></p>
            <p><a href="?do=exit">Выйти</a></p>
        </div>
    </div>
    <?php else: ?>
        <p>Показаны абитуриенты, найденные по запросу "<?php echo $_GET['search']?>"</p>
        <div class="searchlist">
            <table>
                <tr>
                    <th>Имя</th><th>Фамилия</th><th>Количество баллов</th>
                </tr>
                <?php
                    foreach ($result_search as $arr) {
                        echo "<tr>";
                            echo "<td>{$arr['name']}</td><td>{$arr['lastname']}</td><td>{$arr['score']}</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <div class="links">
            <a href="?do=delete">Вернуться к списку</a>
        </div>
    <?php endif; ?>
<?php else: ?> 
    <div class="alert">
        Вам нужно войти в систему!
    </div>
<?php endif; ?>
