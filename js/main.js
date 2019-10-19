document.addEventListener("DOMContentLoaded", function() {
  var elems = document.querySelectorAll("select");
  var instances = M.FormSelect.init(elems);

  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems);

});

function resetRefineResults() {
  let optionsForm = document.querySelector(".refine-results-form");
  optionsForm.reset();
  console.log("reset");
  window.location.replace("https://postr.awettech.com/");
}
