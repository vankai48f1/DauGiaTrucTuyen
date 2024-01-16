<script src="{{ asset('public/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
<script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
<script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
<script>
    (function ($) {
        "use strict";

        $('#languageForm').cValidate({
            rules : {
                'name' : 'required|escapeInput',
                'short_code' : 'required|escapeInput|min:2|max:2',
                'icon' : 'image|max:100',
                'is_active' : 'required|escapeInput|in:{{ array_to_string(active_status()) }}'
            }
        });
    })(jQuery);
</script>
