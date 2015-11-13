
function average(){
  var avg = 0;
  var ok = 1;
  for(var i = 0; i < average.arguments.length; i++){
    avg += Number(average.arguments[i]);
    if(average.arguments[i] == "-"){
      ok = 0;
    }
  }

  if(average.arguments.length == 4){
    if(ok == 1){
      document.getElementById('s1').value = String((avg/average.arguments.length).toFixed(2));
    }else {
      document.getElementById('s1').value = "-";
    }
  }else if (average.arguments.length == 5) {
    if(ok == 1){
      document.getElementById('s4').value = String((avg/average.arguments.length).toFixed(2));
    }else {
      document.getElementById('s4').value = "-";
    }
  }

}

function avg_s2(){
  var avg = 0;
  var ok = 1;
  for(var i = 0; i < avg_s2.arguments.length; i++){
    avg += Number(avg_s2.arguments[i]);
    if(avg_s2.arguments[i] == "-"){
      ok = 0;
    }
  }

  if(ok == 1){
    document.getElementById('s2').value = String((avg/avg_s2.arguments.length).toFixed(2));
  }else {
    document.getElementById('s2').value = "-";
  }
}

function avg_s3(){
  var avg = 0;
  var ok = 1;
  for(var i = 0; i < avg_s3.arguments.length; i++){
    avg += Number(avg_s3.arguments[i]);
    if(avg_s3.arguments[i] == "-"){
      ok = 0;
    }
  }

  if(ok == 1){
    document.getElementById('s3').value = String((avg/avg_s3.arguments.length).toFixed(2));
  }else {
    document.getElementById('s3').value = "-";
  }
}

function tot(){
  var sum = 0;
  var ok = 1;
  for(var i = 0; i < tot.arguments.length; i ++){
    if(tot.arguments[i] == "-"){
      ok = 0;
    }
  }

  sum = (Number(tot.arguments[0])*0.1) + (Number(tot.arguments[1])*0.4) + (Number(tot.arguments[2])*0.25) + (Number(tot.arguments[3])*0.25)

  if(ok == 1){
      document.getElementById('s5').value = String(sum.toFixed(2));
  }else {
    document.getElementById('s5').value = "-";
  }
}

$(input).change(function(){
  alert("change");
});

function grade(){
  if (grade.arguments[0] == "-") {
    document.getElementById('s6').value = "F";
  }
  else if (Number(grade.arguments[0]) == 0) {
    document.getElementById('s6').value = "FX";
  }
  else if (Number(grade.arguments[0]) >= 4.5) {
    document.getElementById('s6').value = "A";
  }
  else if (Number(grade.arguments[0]) >= 3.5) {
    document.getElementById('s6').value = "B";
  }
  else if (Number(grade.arguments[0]) >= 2.5) {
    document.getElementById('s6').value = "C";
  }
  else if(Number(grade.arguments[0]) >= 1.5) {
    document.getElementById('s6').value = "D";
  }
  else {
    document.getElementById('s6').value = "E";
  }
}

function check(){
  var ok = 1;
  for(var i = 0; i < check.arguments.length; i ++){
    var tmp = Number(check.arguments[i]);
    if(tmp == 0 || check.arguments[i] == "-"){
      ok = 0;
    }
  }

  if(check.arguments.length == 3){
    document.getElementById('s1').value = String(ok);
  }else if (check.arguments.length == 4) {
    document.getElementById('s2').value = String(ok);
  }else if (check.arguments.length = 5) {
    document.getElementById('s3').value = String(ok);
  }
}

function pass(){
  var g = 0;
  for(var i = 0; i < pass.arguments.length; i ++){
    if(Number(pass.arguments[i]) == 1){
      g += 1;
    }
  }

  if(g == 3){
    document.getElementById('s4').value = "G";
  }else if (g == 0) {
    document.getElementById('s4').value = "U";
  }else {
    document.getElementById('s4').value = "UX";
  }
}
