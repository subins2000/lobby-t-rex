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

  $html = "<ol class='collection'>";
  foreach($scores as $date => $score){
    $html .= "<li class='collection-item' title='On ". Lobby\Time::date($date) ."'>$score</li>";
  }
  $html .= "</ol>";
  echo $html;
}else if($type === "online"){
  try{
    $response = Requests::post("http://server.lobby.sim/services/t-rex/leaderboard.php", array(), array(
      "lid" => Lobby::getLID()
    ));
  }catch(Exception $e){
    echo "0";
  }

  $result = json_decode($response->body, true);
  echo "<ol class='collection'>";
  foreach($result as $r){
    echo "<li class='collection-item' title='" . ($r["lid"] === Lobby::getLID() ? "You scored this on " : "Scored on "). Lobby\Time::date($r["uploaded"]) ."'><i>{$r["name"]} -&nbsp;</i><b>{$r["score"]}</b></li>";
  }
  echo "</ol>";

  if(Lobby\DB::getOption("profile-name") == null){
    echo sme("Set A Name", "Add your name in ". Lobby::l("/admin/settings.php", "Lobby Settings") ." to upload your top score.");
  }
}