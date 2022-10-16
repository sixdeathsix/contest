<?php

header('Content-type: json/application');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

$connect = mysqli_connect('localhost', 'root', '', 'contest');

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];

$params = explode('/', $q);

$type = $params[0];

$id = $params[1];

if ($method == 'GET') {

  if ($type == 'news') {
    
    $items = mysqli_query($connect, "
      SELECT * FROM `news`
    ");

    $itemList = [];

    while ($item = mysqli_fetch_assoc($items)) {
      $itemList[] = $item;
    }

    if (mysqli_num_rows($items) == 0) {
      echo 'Нет данных';
    } else {
      echo json_encode($itemList);
    }

  }

  if ($type == 'currency') {
    
    $items = mysqli_query($connect, "
      SELECT e.id, e.name as title, e.abb, e.buy, e.sell, h.name as holding FROM `exchanges` e
      LEFT JOIN holdings h on h.id = e.holding;
    ");

    $itemList = [];

    while ($item = mysqli_fetch_assoc($items)) {
      $itemList[] = $item;
    }

    if (mysqli_num_rows($items) == 0) {
      echo 'Нет данных';
    } else {
      echo json_encode($itemList);
    }

  }

  if ($type == 'holding') {
    
    $items = mysqli_query($connect, "
      SELECT * from holdings
    ");

    $itemList = [];

    while ($item = mysqli_fetch_assoc($items)) {
      $itemList[] = $item;
    }

    if (mysqli_num_rows($items) == 0) {
      echo 'Нет данных';
    } else {
      echo json_encode($itemList);
    }

  }

  if ($type == 'job') {
    
    $items = mysqli_query($connect, "
      SELECT * FROM `advertisements`
    ");

    $itemList = [];

    while ($item = mysqli_fetch_assoc($items)) {
      $itemList[] = $item;
    }

    if (mysqli_num_rows($items) == 0) {
      echo 'Нет данных';
    } else {
      echo json_encode($itemList);
    }

  }

}

if ($method == 'POST') {

  if($type == 'news') {

    $title = $_POST['title'];
    $text = $_POST['text'];
    $image = $_POST['image'];

    $item = mysqli_query($connect, "
      INSERT INTO `news` (`id`, `title`, `text`, `image`) VALUES (NULL, '$title', '$text', '$image')
    ");

    echo json_encode($item);
  
  }

  if($type == 'currency') {

    $holding = $_POST['holding'];
    $name = $_POST['name'];
    $abb = $_POST['abb'];
    $buy = $_POST['buy'];
    $sell = $_POST['sell'];

    $item = mysqli_query($connect, "
      INSERT INTO `exchanges` (`id`, `holding`, `name`, `abb`, `buy`, `sell`) VALUES (NULL, '$holding', '$name', '$abb', '$buy', '$sell')
    ");

    echo json_encode($item);
  
  }

  if($type == 'job') {

    $job = $_POST['job'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];

    $item = mysqli_query($connect, "
      INSERT INTO `advertisements` (`id`, `job`, `image`, `description`, `salary`) VALUES (NULL, '$job', '$image', '$description', '$salary')
    ");

    echo json_encode($item);
  
  }

}

if ($method == 'DELETE') {

  if($type == 'news') {

    $item = mysqli_query($connect, "
      DELETE FROM news WHERE `news`.`id` = '$id'
    ");

    echo json_encode($item);
  
  }

  if($type == 'currency') {

    $item = mysqli_query($connect, "
      DELETE FROM `exchanges` WHERE `exchanges`.`id` = '$id'
    ");

    echo json_encode($item);
  
  }

  if($type == 'job') {

    $item = mysqli_query($connect, "
      DELETE FROM `advertisements` WHERE `advertisements`.`id` = '$id'
    ");

    echo json_encode($item);
  
  }

}