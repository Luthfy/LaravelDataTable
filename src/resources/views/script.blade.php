<script type="text/javascript">
    $(document).ready(function() {
        window.datatable = {};
        datatable.{{ $attr['id'] }} = $('table#{{ $attr['id'] }}').DataTable({
            ajax: '{{ $ajax }}',
            columns: [
                {!! $data->implode(', ') !!}
            ]
        })
    });
</script>
