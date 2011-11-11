// Get Started animation

var float = function () {
      $('.getstarted').animate({
        top: "+=10"
      }, 300, 
      function() {
        $('.getstarted').animate({
          top: "-=10"
        }, 300, function() { setTimeout(float, 4800); });
			});
};

setTimeout(float, 4800);

