
<table class="table table-hover">
    <thead>
        <tr>
            <th>bitpay_id</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->bitpay_id }}</td>
            <td>{{ $payment->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


<a href="{{ url('/') }}">shop more</a>
