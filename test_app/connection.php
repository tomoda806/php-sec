<?php
require_once('config.php');

function connectPdo()
{
  try {
    return new PDO(DSN, DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

function createTodoData($todoText)
{
  $dbh = connectPdo();
  $sql = 'INSERT INTO todos (content) VALUES ("' . $todoText . '")';
  $dbh->query($sql);
  // var_dump($dbh->query($sql));
  // exit;
}

function getAllRecords()
{
  $dbh = connectPdo();
  $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
  // echo '<pre>';
  // var_dump($dbh->query($sql)->fetchAll());
  // echo '</pre>';
  return $dbh->query($sql)->fetchAll();
}

function updateTodoData($post)
{
  $dbh = connectPdo();
  $sql = 'UPDATE todos SET content = "' . $post['content'] . '" WHERE id = ' . $post['id'];
  $dbh->query($sql);
}

function getTodoTextById($id)
{
  $dbh = connectPdo();
  $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL AND id = ' . $id;
  // var_dump($sql);
  $data = $dbh->query($sql)->fetch();
  return $data['content'];
}

function deleteTodoData($id)
{
  $dbh = connectPdo();
  $now = date('Y-m-d H:i:s');
  $sql = 'UPDATE todos SET deleted_at = "' . $now . '" WHERE id = ' . $id;
  $dbh->query($sql);
}