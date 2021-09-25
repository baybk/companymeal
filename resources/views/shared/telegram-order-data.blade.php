
<b># {{ $title }}</b>

@foreach($orderData as $key => $value)
    @if (!is_array($value))
<b> </b>
<b>{{ transOrderKey($key) }} : {{ $value }}</b>
    @endif
@endforeach
<b> </b>

<b># CÁC SẢN PHẨM ĐẶT MUA:</b>
@foreach($orderData['lines'] as $key2 => $value2)
<b> </b>
<i>- - - - - SẢN PHẨM {{ $loop->index + 1 }} - - - - - </i>
    @php
        $linkProduct = FE_URL . '/product.html?pid=' . $value2['productId']
    @endphp
<b> </b>
<b>   Link sản phẩm : {{ $linkProduct }}</b>
    @foreach($value2 as $key3 => $value3)
        @if (!is_array($value3) && $key3 != 'productId' && $key3 != 'thumbnail')
           @if ($key3 != "price")
<b> </b>
<b>   {{ transOrderKey($key3) }} : {{ $value3 }}</b>
           @else
<b> </b>
<b>   {{ transOrderKey($key3) }} : {{ number_format($value3) }} đ</b>
           @endif
        @endif
    @endforeach
@endforeach