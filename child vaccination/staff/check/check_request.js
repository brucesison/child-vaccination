// function table() {
//   const xhttp = new XMLHttpRequest();
//   xhttp.onload = function () {
//     document.getElementById("rt-data").innerHTML = this.responseText;
//   };
//   xhttp.open("GET", "./check/fetch_request.php");
//   xhttp.send();
// }

// setInterval(function () {
//   table();
// }, 4000);

function table() {
  fetch("./check/fetch_request.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("rt-data").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));

  fetch("./check/check_request_count.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("rt-count").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));

  fetch("./check/check_notif.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("rt-badge").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));
}

setInterval(function () {
  table();
}, 5000); // Refresh every 5 seconds
