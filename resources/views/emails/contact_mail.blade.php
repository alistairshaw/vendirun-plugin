<html>
	<body>
		<p>Sending Mail</p>
		@foreach($mailData as $key => $row)
			<p>{{ $key }} :  {{ $row }}</p>
		@endforeach
	</body>
</html>