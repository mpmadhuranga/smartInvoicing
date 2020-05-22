<script>
    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(function () {
        $('#filter').keyup(function () {
            if($('#filter').val().length > 2 || $('#filter').val().length === 0) {
                delay(function () {
                    let filter_results = $('#filter_results');
                    filter_results.html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');
                    $.post('<?php echo site_url('filter/ajax/' . $filter_method); ?>',
                        {
                            filter_query: $('#filter').val()
                        }, function (data) {
                            <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                            $('#filter_results').html(data);
                        });
                }, 1000);
            }
        });
    });

</script>