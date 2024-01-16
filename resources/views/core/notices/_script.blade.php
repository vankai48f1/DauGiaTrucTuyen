<!-- for datatable and date picker -->
<script src="{{ asset('public/plugins/moment.js/moment.min.js') }}"></script>
<script src="{{ asset('public/plugins/bs4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('public/plugins/cvalidator/cvalidator-language-en.js') }}"></script>
<script src="{{ asset('public/plugins/cvalidator/cvalidator.js') }}"></script>
<script type="text/javascript">
    (function ($) {
        "use strict";

        //Init jquery Date Picker
        $('#start_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        });

        $('#end_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        });

        $("#start_time").on("dp.change", function (e) {
            $('#end_time').data("DateTimePicker").minDate(e.date);
        });
        $("#end_time").on("dp.change", function (e) {
            $('#start_time').data("DateTimePicker").maxDate(e.date);
        });

        $('#noticeForm').cValidate({
            rules : {
                'title' : 'required',
                'description' : 'required',
                'type' : 'required|in:{{ array_to_string(notices_types()) }}',
                'visible_type' : 'required|in:{{ array_to_string(notices_visible_types()) }}',
                'start_at' : 'dateTime:YYYY-MM-DD HH:mm:ss',
                'end_at' : 'dateTime:YYYY-MM-DD HH:mm:ss',
                'is_active' : 'required|in:{{ array_to_string(active_status()) }}'
            }
        });
    })(jQuery);
</script>
