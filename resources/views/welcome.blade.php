<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="{{ route('pay') }}" method="POST" role="form">
        {{ csrf_field() }}
        <legend>Pay Here</legend>
    
        <input type="hidden" name="amount" value="1">
        
        
    
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


    <br>
    <br><br><br>
    
    <a href="{{ url('payment_status') }}">check payment status</a>

    
</body>
</html>