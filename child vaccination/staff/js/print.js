function printPage() {
  var ButtonControl = document.getElementById("btnprint");
  ButtonControl.style.visibility = "hidden";
  window.print();
  ButtonControl.style.visibility = "visible";
}