<script src="{{ asset('public/plugins/moment.js/moment.min.js') }}"></script>
<script src="{{ asset('public/plugins/bs4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{asset('public/plugins/datatables/datatables.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables/table-datatables-responsive.min.js')}}"></script>
<script type="text/javascript">
    //Init jquery Date Picker

    (function ($) {
        "use strict";

        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('.lf-filter-toggler').on('click', function () {
            $('.lf-filter-container').slideToggle();
        });

        $('.download').on('click', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let type = $(this).attr('data-type');
            let params = $(this).closest('form.lf-filter-form').serializeArray().reduce(function (obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            params['type'] = type;
            axios.get(url, {
                params: params
            }).then((response) => {
                if (response.data.file && response.data.name) {
                    var a = document.createElement("a");
                    a.href = response.data.file;
                    a.download = response.data.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                }
            }).catch((error) => {
                    console.log(error)
                }
            );

        });
    }) (jQuery);
</script>
