<table{!! $attr !!}>
    <thead>
        @foreach($data as $row)
            <th{!! $row->get('th')->attr !!}>{!! $row->get('th')->name !!}</th>
        @endforeach
    </thead>
</table>
