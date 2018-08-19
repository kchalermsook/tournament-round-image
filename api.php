<?php
  $json = file_get_contents('php://input');
  $users = json_decode($json, true);
  $users8 = $users['user8']; // always have this
  $users4 = [];
  if(!empty($users['user4'])){
      $users4 = $users['user4'];
  }
  $numIsChoose = 0;
  foreach ($users8 as $user) {
      if ($user['isChoose']) {
          $numIsChoose++;
      }
  }
  function getImageArr4($users, $users4){
    $DEFAULT_NO_IMAGE = "noimage.jpg";
    $result = [];
    // This is for first result
    $level2 = [];
    $level3 = [];
    $level1 = [];
    foreach($users as $user){
      $level1[] = $user['profilePicture'];
      if($user['isChoose']){
        $level2[] = $user['profilePicture'];
      }
    }
    foreach($users4 as $user){
      if($user['isChoose']){
        $level3[] = $user['profilePicture'];
      }
    }
    $result[] = $level1;
    $result[] = $level2;
    $result[] = $level3;
    return $result;
  }

  function getImageArr8($users ){
    $DEFAULT_NO_IMAGE = "noimage.jpg";
    $result = [];
    // This is for first result
    $level2 = [];
    $level3 = [];
    $level1 = [];
    foreach($users as $user){
      $level1[] = $user['profilePicture'];
      if($user['isChoose']){
        $level2[] = $user['profilePicture'];
      }
    }
    foreach(range(1,2 ) as $number){
      $level3[] = $DEFAULT_NO_IMAGE;
    }
    $result[] = $level1;
    $result[] = $level2;
    $result[] = $level3;
    return $result;
  }
  // End Value to use
  if ($numIsChoose % 2 == 0) {
      $len = count($users8);
      $firsthalf = array_slice($users8, 0, $len / 2);
      $secondhalf = array_slice($users8, $len / 2);

      $resultLeft = []; // 8 4 2
      $resultRight = []; // 8 4 2
      if(!empty($users4)){
        // This is for final result
        $firsthalf4 = array_slice($users4, 0, $len / 2);
        $secondhalf4 = array_slice($users4, $len / 2);

        $resultLeft = getImageArr4($firsthalf, $firsthalf4);
        $resultRight = getImageArr4($secondhalf, $secondhalf4);
        var_dump($resultLeft);
      }else{
        $resultLeft = getImageArr8($firsthalf);
        $resultRight = getImageArr8($secondhalf);
        var_dump($resultRight);
      }
  } else {
      echo "Wrong data. This is not the end of round. ". $numIsChoose;
  }
?>
