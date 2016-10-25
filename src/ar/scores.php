<?php
if(!isset($type))
  $type = "local";

if(Request::postParam("type"))
  $type = Request::postParam("type");

if($type === "local"){
  $scores = $this->data->getArray("highscores");

  if(empty($scores)){
    echo sme("No scores yet...", "Play now and score!");
    return;
  }

  arsort($scores);

  $html = "<ol>";
  foreach($scores as $date => $score){
    $html .= "<li title='On ". Lobby\Time::date($date) ."'>$score</li>";
  }
  $html .= "</ol>";
  echo $html;
}