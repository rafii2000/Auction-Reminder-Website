

window.addEventListener("beforeunload", function(event) {
   event.returnValue = "Zostaniesz wylogowany";
   //window.location.href = "http://www.w3schools.com";
});
