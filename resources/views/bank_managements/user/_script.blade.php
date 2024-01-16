<script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
<script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
<script>
    (function ($) {
        "use strict";

        $('.validator-form').cValidate({
            rules : {
                'bank_name' : 'required|max:255',
                'iban' : 'required|max:255',
                'swift' : 'required|max:255',
                'bank_address' : 'required|max:255',
                'account_holder' : 'required|max:255',
                'account_holder_address' : 'required|max:255',
                'country_id' : 'required',
                'is_active' : 'required',
            }
        });
    })(jQuery);
</script>
