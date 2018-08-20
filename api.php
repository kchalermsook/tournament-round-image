<?php
  $json = file_get_contents('php://input');
  $users = json_decode($json, true);
  $users8 = $users['user8']; // always have this
  $users4 = [];
  $users16 = [];
  if(!empty($users['user4'])){
      $users4 = $users['user4'];
  }
  if(!empty($users['user16'])){
      $users16 = $users['user16'];
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

  function getImageArr16($users ){
    $DEFAULT_NO_IMAGE = "noimage.jpg";
    $result = [];
    // This is for first result
    $level2 = [];
    $level3 = [];
    $level1 = [];
    foreach($users as $user){
      $level1[] = $user['profilePicture'];
    }
    foreach(range(1,4 ) as $number){
      $level2[] = $DEFAULT_NO_IMAGE;
    }
    foreach(range(1,2 ) as $number){
      $level3[] = $DEFAULT_NO_IMAGE;
    }
    $result[] = $level1;
    $result[] = $level2;
    $result[] = $level3;
    return $result;
  }

  function groupTo2($finalArr){
    $resultArr = [];
    foreach($finalArr as $levelArr){
      $mainLevelArr = [];
      $i = 0;
      $tempImg = [];
      foreach($levelArr as $img){
        $tempImg[]  = $img;
        if($i > 0 && $i %2 == 1){
          $mainLevelArr[] = $tempImg;
          $tempImg = [];
        }
        $i++;
      }
      $resultArr[] = $mainLevelArr;
    }
    return $resultArr;
  }
  // End Value to use
  if ($numIsChoose % 2 == 0) {
      $len = count($users8);
      $firsthalf = array_slice($users8, 0, $len / 2);
      $secondhalf = array_slice($users8, $len / 2);

      $resultLeft = []; // 8 4 2
      $resultRight = []; // 8 4 2
      if(!empty($users16)){
        $len = count($users16);
        $firsthalf16 = array_slice($users16, 0, $len / 2);
        $secondhalf16 = array_slice($users16, $len / 2);
        $resultLeft = getImageArr16($firsthalf16);
        $resultRight = getImageArr16($secondhalf16);

      }else if(!empty($users4)){
        // This is for final result
        $firsthalf4 = array_slice($users4, 0, $len / 2);
        $secondhalf4 = array_slice($users4, $len / 2);

        $resultLeft = getImageArr4($firsthalf, $firsthalf4);
        $resultRight = getImageArr4($secondhalf, $secondhalf4);
      }else{
        $resultLeft = getImageArr8($firsthalf);
        $resultRight = getImageArr8($secondhalf);
      }
      $finalArr = groupTo2(array_merge($resultLeft, array_reverse($resultRight)) ) ;
  } else {
      echo "Wrong data. This is not the end of round. ". $numIsChoose;
      die();
  }
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Locup Result</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="bracket-container">
    <?php foreach($finalArr as $levelArr){ ?>
      <div class="bracket-level">
        <?php foreach($levelArr as $matchUpArr){ ?>
          <div class="bracket-matchup">
              <?php foreach($matchUpArr as $img){ ?>
            <div class="bracket-team winner">
              <div class="bracket-name"><img class='round-img' src='<?php echo $img;?>' /></div>
            </div>
              <?php } ?>
          </div>
        <?php } ?>
      </div>
    <?php
    }
    ?>
  </div>
</body>

</html>
