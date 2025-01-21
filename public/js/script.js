(function($){
    $(document).ready(function() {
        if (typeof $.fn.intlTelInput !== 'undefined') {
            $(".tel").intlTelInput({
                defaultCountry: "ci",
                preferredCountries: ["ci"]
            });
        }
    });
})(window.jQuery);