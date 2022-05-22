const table_body = document.getElementById("table_body");

const sql_to_js_date = (sqlDate) => {
  //sqlDate in SQL DATETIME format ("yyyy-mm-dd hh:mm:ss.ms")
  var sqlDateArr1 = sqlDate.split("-");
  //format of sqlDateArr1[] = ['yyyy','mm','dd hh:mm:ms']
  var sYear = sqlDateArr1[0];
  var sMonth = (Number(sqlDateArr1[1]) - 1).toString();
  var sqlDateArr2 = sqlDateArr1[2].split(" ");
  //format of sqlDateArr2[] = ['dd', 'hh:mm:ss.ms']
  var sDay = sqlDateArr2[0];
  var sqlDateArr3 = sqlDateArr2[1].split(":");
  //format of sqlDateArr3[] = ['hh','mm','ss.ms']
  var sHour = sqlDateArr3[0];
  var sMinute = sqlDateArr3[1];
  var sqlDateArr4 = sqlDateArr3[2].split(".");
  //format of sqlDateArr4[] = ['ss','ms']
  var sSecond = sqlDateArr4[0];
  var sMillisecond = sqlDateArr4[1];

  return new Date(sYear, sMonth, sDay, sHour, sMinute, sSecond, sMillisecond);
};

const delete_drive = (id) => {
  const xhr = new XMLHttpRequest();
  xhr.open("DELETE", `../api/placement/drives.php?ID=${id}`, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      const got = JSON.parse(xhr.responseText);

      if (got.error) {
        window.alert(got.error);
      }
    }
  };
  xhr.send();
};

function enroll_drive(e) {
  const element = e.currentTarget.parentElement.parentElement;
  console.log(element);

  const id = element.dataset.id;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", `../api/placement/students_register.php?drive=${id}`, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      const got = JSON.parse(xhr.responseText);

      if (got.error) {
        window.alert(got.error);
      } else {
        window.alert("drive enrolled");
      }
    }
  };
  xhr.send();
}

const fill_drives = (arr) => {
  arr.forEach((element) => {
    const got_time = new Date(element.last_date);
    const now = new Date();
    console.log(got_time, now);

    if (now.getTime() > got_time.getTime()) {
      delete_drive(element.drive_id);
    } else {
      const e = `
      <td>${element.job_description}</td>
      <td>${element.about_company}</td>
      <td>${element.eligibility_criteria}</td>
      <td>${element.last_date}</td>
      <td><iframe src='data:${element.document_type};base64,${element.document}' width='500' ></iframe></td>
      <td><button type="button" class="enroll-btn btn btn-warning">
      Enroll
    </button></td>
      `;

      const tr_element = document.createElement("tr");
      let elem_id = document.createAttribute("data-id");
      elem_id.value = element.drive_id;

      tr_element.setAttributeNode(elem_id);
      tr_element.innerHTML = e;

      const enrollbtn = tr_element.querySelector(".enroll-btn");
      enrollbtn.addEventListener("click", enroll_drive);

      table_body.appendChild(tr_element);
    }
  });
};

function get_drives() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "../api/placement/drives.php", true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      const got = JSON.parse(xhr.responseText);

      if (got.error) {
        window.alert(got.error);
      } else {
        fill_drives(got);
      }
    }
  };
  xhr.send();
}

window.addEventListener("DOMContentLoaded", get_drives);
