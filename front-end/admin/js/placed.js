const placed_form = document.getElementById("placed_form");
const departments = document.getElementById("departments");
const semester = document.getElementById("semester");
const students = document.getElementById("students");
const company = document.getElementById("company");
const package = document.getElementById("package");

function get_departments() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "../../api/info/departments.php", true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      const got = JSON.parse(xhr.responseText);

      if (got.error) {
        window.alert(got.error);
      } else {
        fill_departments(got);
      }
    }
  };
  xhr.send();
}

const fill_departments = (arr) => {
  arr.forEach((element) => {
    const e = document.createElement("option");
    let attr = document.createAttribute("value");
    attr.value = element.department_id;
    e.setAttributeNode(attr);
    e.innerHTML = `${element.department}`;

    departments.appendChild(e);
  });
};

const clean_students = () => {
  students.innerHTML = `<option value="default" selected>
  Choose Student...
</option>`;
};

function get_students(e) {
  e.preventDefault();

  clean_students();
  const xhr = new XMLHttpRequest();

  if (departments.value != 0 && semester.value != 0) {
    xhr.open(
      "GET",
      `../../api/info/students.php?dept=${departments.value}&sem=${semester.value}`,
      true
    );
  } else if (departments.value != 0) {
    xhr.open(
      "GET",
      `../../api/info/students.php?dept=${departments.value}`,
      true
    );
  }

  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      const got = JSON.parse(xhr.responseText);

      if (got.error) {
        window.alert(got.error);
      } else {
        fill_students(got);
      }
    }
  };
  xhr.send();
}

const fill_students = (arr) => {
  arr.forEach((element) => {
    const e = document.createElement("option");
    let attr = document.createAttribute("value");
    attr.value = element.student_id;
    e.setAttributeNode(attr);
    e.innerHTML = `${element.first_name} ${element.last_name}`;

    students.appendChild(e);
  });
};

function submit_form(e) {
  e.preventDefault();

  if (!students.value || !company.value || !package.value) {
    window.alert("please enter all the values!");
    return;
  }

  const placed = {
    student_id: students.value,
    company: company.value,
    CTC: package.value,
  };

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../../api/info/placed_students.php", true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      const got = JSON.parse(xhr.responseText);

      if (got.error) {
        window.alert(got.error);
      } else {
        window.alert("Uploaded successfully");
        departments.value = 0;
        semester.value = 0;
        students.value = "default";
        company.value = "";
        package.value = "";
      }
    }
  };
  xhr.send(JSON.stringify(placed));
}

window.addEventListener("DOMContentLoaded", get_departments);
departments.addEventListener("change", get_students);
semester.addEventListener("change", get_students);
placed_form.addEventListener("submit", submit_form);
