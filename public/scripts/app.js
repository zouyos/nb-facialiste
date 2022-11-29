let formSubmitting = false;
let setFormSubmitting = function () {
  formSubmitting = true;
};

window.addEventListener("beforeunload", function (e) {
  if (formSubmitting) {
    return undefined;
  }
  var confirmationMessage =
    "Il existe des changements non enregistrés." +
    "Si vous quittez la page ces données seront perdues.";

  (e || window.event).returnValue = confirmationMessage; //Gecko + IE
  return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
});
