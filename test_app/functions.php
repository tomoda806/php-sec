<?php
require_once('connection.php');

// function createData($post)
// {
//   createTodoData($post['content']);
//   var_dump($post['content']);
//   exit;
// }

function getTodoList()
{
  return getAllRecords();
}

function getSelectedTodo($id)
{
  return getTodoTextById($id);
}

function savePostedData($post)
{
  $path = getRefererPath();
  switch ($path) {
    case '/new.php':
      createTodoData($post['content']);
        break;
    case '/edit.php':
      updateTodoData($post);
        break;
    case '/index.php':
      deleteTodoData($post['id']);
        break;
      default:
        break;
  }
}

function getRefererPath()
{
  $urlArray = parse_url($_SERVER['HTTP_REFERER']); //,PHP_URL_PATH
  // echo '<pre>';
  // var_dump($urlArray);
  // echo '</pre>';
  // exit;
  return $urlArray['path'];
}

function e($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}