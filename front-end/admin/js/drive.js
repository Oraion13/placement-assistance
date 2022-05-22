const drive_form = document.getElementById("drive_form");
const JobDescription = document.getElementById("JobDescription");
const AboutCompany = document.getElementById("AboutCompany");
const EligibilityCriteria = document.getElementById("EligibilityCriteria");
const lastDate = document.getElementById("lastDate");   
const Document = document.getElementById("Document");

drive_form.addEventListener("submit", driveform_submit);

function driveform_submit(e) {
    e.preventDefault();

    const formData = new FormData();

    formData.append('document', Document.files[0]);
    formData.append('job_description', JobDescription.value);
    formData.append('about_company', AboutCompany.value);
    formData.append('eligibility_criteria', EligibilityCriteria.value);
    formData.append('last_date', lastDate.value);
  
    const xhr = new XMLHttpRequest();
  
    xhr.open("POST", "../../api/placement/drives.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            const got = JSON.parse(xhr.responseText);

            if (got.error) {
                window.alert(got.error);
            } else {
                window.alert("Uploaded successfully");
                JobDescription.value = '';
                AboutCompany.value = '';
                EligibilityCriteria.value = '';
                lastDate.value = '';
                // window.location.replace("./index.php");
            }
        }
    };
    xhr.send(formData);
}