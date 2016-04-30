var WINDOW_WIDTH = 1024;
var WINDOW_HEIGHT = 568;
var RADIUS = 8;
var MARGIN_TOP = 60;
var MARGIN_LEFT = 30;
const endTime = new Date(2015,11,14,03,50,00);
console.log('endTime',endTime);
var currentShowTimeSeconds = 0;
var ball = {x:512,y:100,r:10,g:2,vx:-4,vy:0,color:'#005588'};
var balls = [];
const colors = ['#33BSE5','#0099CC','#AA66CC','#9933CC','#669900','#FFBB33','FF8800','FF4444','#CC0000'];

window.onload = function(){

    var canvas = document.getElementById('canvas');
    var context = canvas.getContext("2d");

    canvas.width = WINDOW_WIDTH;
    canvas.height = WINDOW_HEIGHT;
    currentShowTimeSeconds = getCurrentShowTime();
    setInterval(function(){
        render( context );
        update();
    },50);
}

function getCurrentShowTime(){
    var curTime = new Date();
    var ret = endTime.getTime() - curTime.getTime();
    ret = Math.round(ret/1000);
    return ret >= 0?ret:0;

}
function ball_up(){
    ball.x += ball.vx;
    ball.y += ball.vy;
    ball.vy += ball.g;
    if(ball.y >= 500 - ball.r){
        ball.y = 500 - ball.r;
        ball.vy = -ball.vy*0.5;
    }
    if(ball.x - ball.r <= 0 || ball.x >= WINDOW_WIDTH - ball.r){
        ball.vx = -ball.vx;
    }
}
function updateBalls(){
        var cnt = 0;
        for(var i=0;i<balls.length;i++){ 
            if((balls[i].x  + RADIUS > 0 && balls[i].x - RADIUS < WINDOW_WIDTH)){
                balls[cnt++] = balls[i];
            }
        }
        while(balls.length> Math.min(300,cnt)){
            balls.pop();
        }
    for(var i=0;i<balls.length;i++){
        balls[i].x += balls[i].vx;
        balls[i].y += balls[i].vy;
        balls[i].vy += balls[i].g;
        if(balls[i].y>=WINDOW_HEIGHT-RADIUS){
            balls[i].y=WINDOW_HEIGHT-RADIUS;
            balls[i].vy = -balls[i].vy*0.4;
        }
    }
}

function update(){
    var nextShowTimeSeconds = getCurrentShowTime();
    var nextHours = parseInt(nextShowTimeSeconds/3600);
    var nextMinutes = parseInt((nextShowTimeSeconds-nextHours*3600)/60);
    var nextSeconds = nextShowTimeSeconds%60;

    var curHours = parseInt(currentShowTimeSeconds/3600);
    var curMinutes = parseInt((currentShowTimeSeconds-curHours*3600)/60);
    var curSeconds = currentShowTimeSeconds%60;

    if(nextSeconds != curSeconds){
        if(parseInt(curHours/10) != parseInt(nextHours/10)){
            addBalls(MARGIN_LEFT+0,MARGIN_TOP,parseInt(nextHours/10));
        }
        if(parseInt(curHours%10) != parseInt(nextHours%10)){
            addBalls(MARGIN_LEFT+15*(RADIUS+1),MARGIN_TOP,parseInt(nextHours%10));
        }

        if(parseInt(curMinutes/10) != parseInt(nextMinutes/10)){
            addBalls(MARGIN_LEFT+39*(RADIUS+1),MARGIN_TOP,parseInt(nextMinutes/10));
        }
        if(parseInt(curMinutes%10) != parseInt(nextMinutes%10)){
            addBalls(MARGIN_LEFT+54*(RADIUS+1),MARGIN_TOP,parseInt(nextMinutes%10));
        }

        if(parseInt(curSeconds/10) != parseInt(nextSeconds/10)){
            addBalls(MARGIN_LEFT+78*(RADIUS+1),MARGIN_TOP,parseInt(nextSeconds/10));
        }
        if(parseInt(curSeconds%10) != parseInt(nextSeconds%10)){
            addBalls(MARGIN_LEFT+93*(RADIUS+1),MARGIN_TOP,parseInt(nextSeconds%10));
        }
        currentShowTimeSeconds = nextShowTimeSeconds;
    }
    // ball_up();
    updateBalls();
    console.log(balls.length);
}
function ball_render(cxt){
    cxt.fillStyle = ball.color;
    cxt.beginPath();
    cxt.arc(ball.x,ball.y,ball.r,0,2*Math.PI);
    cxt.closePath();
    cxt.fill();
}
function renderBalls(cxt){
    for(var i=0;i<balls.length;i++){
        cxt.fillStyle = balls[i].color;
        cxt.beginPath();
        cxt.arc(balls[i].x,balls[i].y,RADIUS,0,2*Math.PI);
        cxt.closePath();
        cxt.fill();
        // console.log(true);
    }

}
function render( cxt ){
    cxt.clearRect(0,0,WINDOW_WIDTH,WINDOW_HEIGHT);
    var hours = parseInt(currentShowTimeSeconds/3600);
    var minutes = parseInt((currentShowTimeSeconds-hours*3600)/60);
    var seconds = currentShowTimeSeconds%60;
    // console.log('s',seconds);

    renderDigit( MARGIN_LEFT , MARGIN_TOP , parseInt(hours/10) , cxt )
    renderDigit( MARGIN_LEFT + 15*(RADIUS+1) , MARGIN_TOP , parseInt(hours%10) , cxt )
    renderDigit( MARGIN_LEFT + 30*(RADIUS + 1) , MARGIN_TOP , 10 , cxt )
    renderDigit( MARGIN_LEFT + 39*(RADIUS+1) , MARGIN_TOP , parseInt(minutes/10) , cxt);
    renderDigit( MARGIN_LEFT + 54*(RADIUS+1) , MARGIN_TOP , parseInt(minutes%10) , cxt);
    renderDigit( MARGIN_LEFT + 69*(RADIUS+1) , MARGIN_TOP , 10 , cxt);
    renderDigit( MARGIN_LEFT + 78*(RADIUS+1) , MARGIN_TOP , parseInt(seconds/10) , cxt);
    renderDigit( MARGIN_LEFT + 93*(RADIUS+1) , MARGIN_TOP , parseInt(seconds%10) , cxt);
    // ball_render(cxt);
    renderBalls(cxt);
}

function renderDigit( x , y , num , cxt ){

    cxt.fillStyle = "rgb(0,102,153)";

    for( var i = 0 ; i < digit[num].length ; i ++ )
        for(var j = 0 ; j < digit[num][i].length ; j ++ )
            if( digit[num][i][j] == 1 ){
                cxt.beginPath();
                cxt.arc( x+j*2*(RADIUS+1)+(RADIUS+1) , y+i*2*(RADIUS+1)+(RADIUS+1) , RADIUS , 0 , 2*Math.PI )
                cxt.closePath()

                cxt.fill()
            }
}

function addBalls(x,y,num){
    for( var i = 0 ; i < digit[num].length ; i ++ )
        for(var j = 0 ; j < digit[num][i].length ; j ++ )
            if( digit[num][i][j] == 1 ){
                var aBall = {
                    x: x+j*2*(RADIUS+1)+(RADIUS+1),
                    y: y+i*2*(RADIUS+1)+(RADIUS+1),
                    g: 1.5 + Math.random(),
                    vx:Math.pow(-1,Math.ceil(Math.random()*1000))*6,
                    vy:-5,
                    color:colors[Math.floor(Math.random()*colors.length)]
                }
                balls.push(aBall);
            }
}