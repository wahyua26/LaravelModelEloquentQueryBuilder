<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pegawai</title>
</head>
<body>
    <h1> Data Pegawai </h1>
    <ul>
        @foreach($pegawai as $p)
            <li>{{  $p }}</li>
        @endforeach
    </ul>
</body>
</html>