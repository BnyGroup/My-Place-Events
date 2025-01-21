var input = document.querySelector("#phone"),
    input2 = document.querySelector("#phone2"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Rajoutez l'indicatif svp", "Indicatif invalide", "Trop court", "Trop Long", "Incorrect"];

if (typeof input != 'undefined') {

    // initialise plugin
    var iti = window.intlTelInput(input, {
      initialCountry: 'ci',
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",//"https://myplace-events.com/public/js/utils.js"
    });

    var reset = function() {
      input.classList.remove("error");
      errorMsg.innerHTML = "";
      errorMsg.classList.add("hide");
      validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function() {
      reset();
      if (input.value.trim()) {
        if (iti.isValidNumber()) {
          validMsg.classList.remove("hide");
          //document.querySelector('.btn-payment').removeAttribute("disabled");
          $('.btn-payment').removeAttr("disabled");
        } else {
          input.classList.add("error");
      //    document.querySelector('.btn-payment').setAttribute('disabled', true);
          $('.btn-payment').attr('disabled', true);

          var errorCode = iti.getValidationError();
          errorMsg.innerHTML = errorMap[errorCode];
          errorMsg.classList.remove("hide");
        }
      }
    });

    // on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

}


if (typeof input2 != 'undefined') {

    // initialise plugin
    var iti = window.intlTelInput(input, {
      initialCountry: 'ci',
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",//"https://myplace-events.com/public/js/utils.js"
    });

    var reset = function() {
      input.classList.remove("error");
      errorMsg.innerHTML = "";
      errorMsg.classList.add("hide");
      validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function() {
      reset();
      if (input.value.trim()) {
        if (iti.isValidNumber()) {
          validMsg.classList.remove("hide");
          //document.querySelector('.btn-payment').removeAttribute("disabled");
          $('.btn-payment').removeAttr("disabled");
        } else {
          input.classList.add("error");
      //    document.querySelector('.btn-payment').setAttribute('disabled', true);
          $('.btn-payment').attr('disabled', true);

          var errorCode = iti.getValidationError();
          errorMsg.innerHTML = errorMap[errorCode];
          errorMsg.classList.remove("hide");
        }
      }
    });

    // on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

}