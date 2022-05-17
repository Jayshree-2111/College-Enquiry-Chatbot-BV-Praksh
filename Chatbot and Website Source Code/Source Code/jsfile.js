//faculty_jsfile.js
const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

function checkValid() {
  let mail = document.getElementById("emailid").value;
  let format = /^\"?[\w-_\.]*\"?@banasthali\.in$/.test(mail);
  if (!format)
   document.getElementById("mail").innerHTML = "Enter a valid banasthali email id!";
  else{
  const myForm = document.getElementById("registration-form");
  document.querySelector(".btn").addEventListener("click", function(){

  myForm.submit();
  });
  }
}
//Same for student_jsfile.js
