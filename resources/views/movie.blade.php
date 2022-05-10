<!DOCTYPE html>
<html>
<head>
	<title>Data movie</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<div class="card mt-5">
			<div class="card-body">
				<h5 class="text-center my-4">Data movie</h5>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>title</th>
							<th>description</th>
							<th width="1%">genre</th>
						</tr>
					</thead>
					<tbody>
						@foreach($movies as $a)
						<tr>
							<td>{{ $a }}</td>
							<td>
                               {{-- {{ $a->description }} --}}
							</td>
							{{-- <td class="text-center">{{ $a->genre }}</td> --}}
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

</body>
</html>