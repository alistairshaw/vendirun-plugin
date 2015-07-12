<html>
	<body>
		<p>Sendin Mail</p>
		@foreach($mailData as $key => $row)
			<p>{{ $key }} :  {{ $row }}</p>
		@endforeach
	</body>
</html>