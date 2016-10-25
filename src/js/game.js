$.extend(lobby.app, {

  highScore: 0,

  init: function(){
    this.ar("top-score", {}, function(score){
      lobby.app.highScore = parseInt(score);
    });

    // Start the game
    new Runner("#game");
  },

  loadScores: function(){
    this.ar("scores", {"type": "local"}, function(scores){
      $("#highscores #local .scores").html(scores);
    });
  },

  newHighScore: function(score){
    var score = Number(score).toString();
    this.ar("save-score", {"score": score}, function(){
      lobby.app.loadScores();
    });
  }

});

lobby.load(function(){
  lobby.app.init();
});