let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn")
closeBtn.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  menuBtnChange();
});
function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
  } else {
    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
  }
}
function up() {
      var formData = new FormData();
      formData.append("type", "admin")
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "rtupdate.php", true);
      const a=document.getElementById("all_slots");
      const b=document.getElementById("active_slots");
      const c=document.getElementById("empty_slots");

      xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
              var res = xhr.responseText;
             var text=res.split(":");
             a.innerText=text[2];
             b.innerText=text[1];
             c.innerText=text[0];
          }
      }
      xhr.send(formData);
  }
  setInterval(up,1000)