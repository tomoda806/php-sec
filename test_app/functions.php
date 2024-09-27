<?php
require_once('connection.php');
session_start(); //読み込まれた時点でSESSIONを開始

function e($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// SESSIONにtokenを格納する
function setToken()
{
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
}

// SESSIONに格納されたtokenのチェックを行い、SESSIONにエラー文を格納する
function checkToken($token)
{
    if (empty($_SESSION['token']) || ($_SESSION['token'] !== $token)) {
        $_SESSION['err'] = '不正な操作です';
        redirectToPostedPage();
    }
}

function unsetError()
{
    $_SESSION['err'] = '';
}

function redirectToPostedPage()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

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
  checkToken($post['token']);
  validate($post);
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

function validate($post)
{
    if (isset($post['content']) && $post['content'] === '') {
        $_SESSION['err'] = '入力がありません';
        redirectToPostedPage();
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