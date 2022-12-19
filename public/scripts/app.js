let formSubmitting = false;
let setFormSubmitting = function () {
  formSubmitting = true;
};

window.addEventListener("beforeunload", function (e) {
  if (formSubmitting) {
    return undefined;
  }
  let confirmationMessage =
    "Il existe des changements non enregistrés." +
    "Si vous quittez la page ces données seront perdues.";

  (e || window.event).returnValue = confirmationMessage;
  return confirmationMessage;
});