<?php
$scores = $this->data->getArray("highscores");

if(empty($scores)){
  echo "0";
}else{
  rsort($scores);
  echo $scores[0];
}
?>