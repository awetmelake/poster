
document.addEventListener("DOMContentLoaded", function() {
  var elems = document.querySelectorAll("select");
  var instances = M.FormSelect.init(elems);

});

function resetRefineResults() {
  let optionsForm = document.querySelector(".refine-results-form");
  optionsForm.reset();
  console.log("reset");
  window.location.replace("http://localhost:8000/project/index.php");
}