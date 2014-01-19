<!DOCTYPE html>
<html>
	<head>
		<link href="/css/main.css?v=1" rel="stylesheet"></link>
		<script src="/js/jquery-1.10.2.min.js"></script>
		<script src="/js/main.js"></script>
	</head>
	<body>
		<h1>Web-приложение для тестирования API сервера</h1>
		{{ Form::open(array('url' => 'send')) }}
			<table>
				<tr>
					<td colspan="3">Request method:
						{{ Form::label('method', 'GET') }}
						{{ Form::radio('method', 'GET', false) }}
						{{ Form::label('method', 'POST') }}
						{{ Form::radio('method', 'POST') }}
					</td>
				</tr>
				<tr>
					<td>url:</td>
					<td colspan="2">{{ Form::text('url', '', array('class' => 'url')) }}</td>
				</tr>
				<tr>
					<td colspan="3">Parameter list:</td>
				</tr>
			@for ($i = 0; $i < 5; $i++)
				<tr>
					<td>Name:</td>
					<td>{{ Form::text('param[]', Session::get('param_'. $i)) }}</td>
					<td>Value: {{ Form::text('value[]', Session::get('value_'. $i)) }}</td>
				</tr>
			@endfor
			</table>
			{{ Form::submit('Send') }}
		{{ Form::close() }}
		@if (Session::has('response'))
		<p>Response:</p>
		<code id="response"></code>
		<script>$('#response').html(formatJSON({{ Session::get('response') }}));</script>
		@endif

		@if (Session::has('errors'))
		<p>Errors:</p>
			@foreach(Session::get('errors')->all() as $error)
				<p class="errors">{{ $error }}</p>
			@endforeach
		<p></p>
		@endif
	</body>
</html>