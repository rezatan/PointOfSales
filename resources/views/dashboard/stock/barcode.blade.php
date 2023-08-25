<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>

    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            @foreach ($datastock as $stock)
                <td class="text-center" style="border: 1px solid #333;">
                    <p>{{ $stock->product->name }} - Rp. {{ format_uang($stock->sell_price) }}</p>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($stock->code, 'C39') }}" 
                        alt="{{ $stock->code }}"
                        width="180"
                        height="60">
                    <br>
                    {{ $stock->code }}
                </td>
                @if ($no++ % 3 == 0)
                    </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>