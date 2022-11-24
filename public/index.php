<?php

declare(strict_types=1);

require_once("../vendor/autoload.php");

use App\DB;
use App\Todo;

function conn(): PDO
{
    return (new DB())->conn();
}

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, "utf-8");
}


$err = (function () {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return "";
    }

    if (isset($_POST["add"])) {
        if (Todo::titleIsNotEmpty($_POST["title"])) {
            return "タイトルが空です。";
        }

        if (Todo::titleLengthIsVailed($_POST["title"])) {
            return "タイトルが長すぎます。";
        }

        Todo::add($_POST["title"]);

        header("Location: /");
        exit();
    }

    if (isset($_POST["done"])) {
        if (!isset($_POST["todos_id"])) {
            return "";
        }

        Todo::remove($_POST["todos_id"]);

        header("Location: /");
        exit();
    }

    return "";
})();

$todos = Todo::getReversedAll();

?>

<!doctype html>
<html>

<head>
    <meta charset=utf-8>
    <title>php-todos</title>
</head>

<body>
    <h1>php-todos</h1>

    <h2>Add todo</h2>
    <form method="post">
        <input type="hidden" name="add">
        <label>
            <div>
                <input type="text" name="title">
                <input type="submit" value="add">
            </div>
        </label>
        <?php echo h($err) ?>
    </form>

    <h2>Remaining todos</h2>
    <form method="post">
        <input type="hidden" name="done">
        <ul>
            <?php foreach ($todos as $todo) { ?>
                <li>
                    <input type="checkbox" name="todos_id[]" value="<?php echo h($todo["id"]) ?>">
                    <?php echo h($todo["title"]) ?>
                </li>
            <?php } ?>
        </ul>
        <input type="submit" value="done">
    </form>
</body>

</html>
