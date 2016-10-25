<?php
$score = Request::postParam("score");

if($score !== null){
  $scores = $this->data->getArray("highscores");
  
  $scores[Lobby\Time::now()] = $score;
  arsort($scores);

  // Keep only top 10 highscores
  $this->data->saveArray("highscores", array_slice($scores, 0, 10));
}