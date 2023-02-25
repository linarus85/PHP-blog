<?php
include_once SITE_ROOT . "/database/db.php";

$errMsg = '';
$id = '';
$name = '';
$description = '';

$topics = selectAllTable('topics');


// Код для формы создания категории
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-create'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['disceptation']);

    if ($name === '' || $description === '') {
        $errMsg = "Не все поля заполнены!";
    } elseif (mb_strlen($name, 'UTF8') < 2) {
        $errMsg = "Категория должна быть более 2-х символов";
    } else {
        $existence = selectTable('topics', ['name' => $name]);
        if ($existence['name'] === $name) {
            $errMsg = "Такая категория уже есть в базе";
        } else {
            $topic = [
                'name' => $name,
                'disceptation' => $description
            ];
            $id = insert('topics', $topic);
            $topic = selectTable('topics', ['id' => $id]);
            header('location: ' . BASE_URL . 'admin/topics/index.php');
        }
    }
} else {
    $name = '';
    $description = '';
}


// Апдейт категории
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectTable('topics', ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['disceptation'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-edit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['disceptation']);

    if ($name === '' || $description === '') {
        $errMsg = "Не все поля заполнены!";
    } elseif (mb_strlen($name, 'UTF8') < 2) {
        $errMsg = "Категория должна быть более 2-х символов";
    } else {
        $topic = [
            'name' => $name,
            'disceptation' => $description
        ];
        $id = $_POST['id'];
        $topic_id = update('topics', $id, $topic);
        header('location: ' . BASE_URL . 'admin/topics/index.php');
    }
}

// Удаление категории
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    delete('topics', $id);
    header('location: ' . BASE_URL . 'admin/topics/index.php');
}
