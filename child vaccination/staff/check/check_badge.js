function badge() {
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
  badge();
}, 5000); // check every 5 seconds
