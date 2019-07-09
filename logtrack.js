$(function()
{ 
  //Getting the username through cookie
  var userEmail = getCookie('email');
  console.log(userEmail);

  // amount of time without input after user is considered inactive
  var timeToInactivity = 3000

  var time;
  // variable that stores total inactivity 
  var totalInactive = 0;
  // varibale that stores the beginning of the current period of inactivity
  var curInactive = null;
  var start = null;
  console.log("hello")

  //Make intial time stamp for when user first 
  window.onload = function(event) {
    start = event.timeStamp;
    console.log(start);
    console.log("bye")
  };

  // reset inactivity timer when window loads
  window.onload = function(event){
    resetTimer(event);
  }

  // reset inactivity timer or end inactivity period when mouse is moved 
  document.onmousemove = function(event) {
    if (curInactive == null){
      resetTimer(event);
    }
    else {
      totalInactive += (event.timeStamp - curInactive);
      curInactive = null;
      resetTimer(event);

    }
  };

  // reset inactivity timer or end inactivity period when the user scrolls through page 
  document.onscroll = function(event) {
    if (curInactive == null){
      resetTimer(event);
    }
    else {
      totalInactive += (event.timeStamp - curInactive);
      curInactive = null;
      resetTimer(event);

    }
  };

  // reset inactivity timer or end inactivity period when the user press a key on keyboard 
  document.onkeydown = function(event) {
    if (curInactive == null){
      resetTimer(event);
    }
    else {
      totalInactive += (event.timeStamp - curInactive);
      curInactive = null;
      resetTimer(event);

    }
  };
  

  // when window is closed or user is redirected
  window.onbeforeunload = function(event) {
    // calcualte total active time
    var activeTime = (event.timeStamp - start) - totalInactive;
    var totalTime = (event.timeStamp - start)
    // Get toadys date
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    // Json object to be sent to backend
    var postData = {"username": userEmail, "timeActive": activeTime, "date": date};
    var dataString = JSON.stringify(postData);
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: "sendtoSleekDB.php",
      data: {userData:dataString},
      success: function(data){
          console.log('success');
      },
      error: function(xhr,textStatus,err)
      {
          console.log("readyState: " + xhr.readyState);
          console.log("responseText: "+ xhr.responseText);
          console.log("status: " + xhr.status);
          console.log("text status: " + textStatus);
          console.log("error: " + err);
      }
    })
    console.log(activeTime);
    console.log(totalTime);
    return "Dont Leave!";
  };


  function resetTimer(event) {
    // reset the inactivity timer
    clearTimeout(time);
    console.log("active")
    // start new inactivity timer
    time = setTimeout(function(){inactive(event)}, timeToInactivity);
    // 1000 milliseconds = 1 second}
  }

  // function is called when user is considered to be inactive
  function inactive(event) {
    console.log('InActive');
    curInactive = event.timeStamp + timeToInactivity;
  }

  
  // function to get value of cookie by name
  function getCookie(input) {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
      var name = cookies[i].split('=')[0].toLowerCase();
      var value = cookies[i].split('=')[1].toLowerCase();
      if (name === input) {
        return value;
      } else if (value === input) {
        return name;
      }
    }
    return "";
    };
}); 