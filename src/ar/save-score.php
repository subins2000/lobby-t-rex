<?php
$score = Request::postParam("score");

if($score !== null){
  $scores = $this->data->getArray("highscores");

  if(in_array($score, $scores)){
    unset($scores[array_search($score, $scores)]);
  }
  
  $scores[Lobby\Time::now()] = $score;
  arsort($scores);

  $this->data->remove("highscores");

  // Keep only top 10 highscores
  $this->data->saveArray("highscores", array_slice($scores, 0, 10));

  /**
   * If this score was the highest of user,
   * upload score to leaderboard
   */
  if($scores[array_keys($scores)[0]] == $score && Lobby\DB::getOption("profile-name") !== null){
    Requests::post("http://server.lobby.sim/services/t-rex/upload-score.php", array(), array(
      "name" => Lobby\DB::getOption("profile-name"),
      "lid" => Lobby::getLID(),
      "score" => $score
    ));
  }
  echo "1";
}