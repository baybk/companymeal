<table class="mytable">
    <thead>
        <th class="myth">Ten</th>
        <th class="myth">Số dư</th>
    </thead>

    <tbody>
    @foreach ($arrayData as $key => $item)
        <tr>
            <td class="mytd">{{ $key }}</td>
            <td class="mytd">{{ $item }}</td>
        </tr>
    @endforeach
    </tbody>
</table>