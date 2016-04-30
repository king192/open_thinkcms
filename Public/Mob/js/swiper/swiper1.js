function span_move_fun(){
 var span = document.getElementById("move_k");
 var span_left = $(span).offset().left;
 var span_top = $(span).offset().top;
 var start_left = $(span).offset().left;
 var start_top = $(span).offset().top;
 span.addEventListener('touchstart', function(event) {
  event.preventDefault();
  if (event.targetTouches.length == 1) {
     var touch = event.targetTouches[0];
     span.style.position = "absolute";
  span_top = $(this).offset().top;
  span_left = $(this).offset().left;
  start_top = touch.pageY
  start_left = touch.pageX
     var left = parseFloat(touch.pageX - start_left + span_left-30);
     var top = parseFloat(touch.pageY - start_top + span_top-73);
  span.style.left = String(left) + 'px';
  span.style.top = String(top) + 'px';
     }
   });
   span.addEventListener('touchmove', function(event) {
  event.preventDefault();
  if (event.targetTouches.length == 1) {
  var touch = event.targetTouches[0];
  span.style.position = "absolute";
  var left = parseFloat(touch.pageX - start_left + span_left-30);
     var top = parseFloat(touch.pageY - start_top + span_top-73);
  span.style.left = String(left) + 'px';
  span.style.top = String(top) + 'px';
  }
 });
   span.addEventListener('touchend', function(event) {
   var touch = event.changedTouches[0];
   if(parseFloat(touch.pageX - start_left + span_left-30) <= -5 || parseFloat(touch.pageX - start_left + span_left-30) >= 620 || parseFloat(touch.pageY - start_top + span_top-73) <= -38 || parseFloat(touch.pageY - start_top + span_top-73) >= 587){
    span.style.left = String(span_left-30) + 'px';
  span.style.top = String(span_top-73) + 'px';
   }
  event.stopPropagation();
 });
}
span_move_fun();