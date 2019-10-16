let salarySwitch = document.querySelector('#toggle-salary');
let hourlySwitch = document.querySelector('#toggle-hourly');

// input containers
let salary_max = document.querySelector('#salary_max');
let salary_min = document.querySelector('#salary_min');
let hourly_max = document.querySelector('#hourly_max');
let hourly_min = document.querySelector('#hourly_min');

// switch init
if (salarySwitch.value === "on") {
  salarySwitch.click();
  salary_max.hidden = false;
  salary_min.hidden = false;
}
if (hourlySwitch  === "on") {
  hourlySwitch.click();
  hourly_max.hidden = false;
  hourly_min.hidden = false;
}
// document.querySelector("#salary_maxSlider").addEventListener("change" , (e) => {console.log(e.target.value)})
// document.querySelector("#salary_minSlider").addEventListener("change" , (e) => {console.log(e.target.value)})
// document.querySelector("#hourly_maxSlider").addEventListener("change" , (e) => {console.log(e.target.value)})
// document.querySelector("#hourly_minSlider").addEventListener("change" , (e) => {console.log(e.target.value)})

salarySwitch.addEventListener('click', () => {
  if (salarySwitch.value === "off") {
    salarySwitch.value = "on"
    salary_max.hidden = false;
    salary_min.hidden = false;
  } else {
    salarySwitch.value = "off";
    salary_max.hidden = true;
    salary_min.hidden = true;
    salary_maxSlider.value = 0;
    salary_minSlider.value = 0;
  }
  // toggle off hourly if salary is selected
  if (salarySwitch.value === "on" && hourlySwitch.value === "on") {
    hourlySwitch.click();
  }
});

hourlySwitch.addEventListener('click', () => {
  if (hourlySwitch.value === "off") {
    hourlySwitch.value = "on";
    salarySwitch.click();

    hourly_max.hidden = false;
    hourly_min.hidden = false;
  } else {
    hourlySwitch.value = "off";
    hourly_max.hidden = true;
    hourly_min.hidden = true;
    hourly_maxSlider.value = 0;
    hourly_minSlider.value = 0;
  }
  // toggle off salary if hourly is selected
  if (salarySwitch.value === "on" && hourlySwitch.value === "on") {
    salarySwitch.click();
  }
});
