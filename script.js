function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('time').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 1000);

  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }
}


function remarkschange(){
  var depart = document.getElementsByTagName('table');
  depart.style.backgroundColor = "red";
  

}


  
 
 window.onload =  function(){
  startTime();
  remarkschange();
};




  


