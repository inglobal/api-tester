<!DOCTYPE html>
<html>
	<head>
		<link href="css/main.css?v=1" rel="stylesheet"></link>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		<script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
	</head>
	<body>
        <div class="wrapper">
            <h1>Web-приложение для тестирования<br />API сервера</h1>
            {{ Form::open(array('url' => 'send', 'class' => 'form-horizontal')) }}
                <div class="form-group">
                    <div class="col-md-12">
                            <h4 class="inline-header">Request method:</h4>
                            {{ Form::label('method', 'GET') }}
                            {{ Form::radio('method', 'GET', true) }}
                            {{ Form::label('method', 'POST') }}
                            {{ Form::radio('method', 'POST') }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('url', 'url:', array('class' => 'col-md-1')) }}
                    <div class="col-md-9">{{ Form::text('url', '', array('class' => 'url form-control')) }}</div>
                </div>
                <div class="form-group">
                    <h4 class="col-md-12">Parameter list:</h4>
                </div>
                @for ($i = 0; $i < 5; $i++)
                <div class="form-group">
                    <div class="col-md-1">{{ Form::label('param[]', 'Name:') }}</div>
                    <div class="col-md-4">{{ Form::text('param[]', Session::get('param_'. $i), array('class' => 'form-control')) }}</div>
                    <div class="col-md-1">{{ Form::label('value[]', 'Value:') }}</div>
                    <div class="col-md-4">{{ Form::text('value[]', Session::get('value_'. $i), array('class' => 'form-control')) }}</div>
                </div>
                @endfor
                <div class="form-group">
                    <div class="col-md-offset-1 col-md-11">{{ Form::submit('Send') }}</div>
                </div>
            {{ Form::close() }}
            @if (Session::has('response'))
            <p>Response:</p>
            <code id="response"></code>
            <script>
                (function () {
                    var response = {{ Session::get('response') }};
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        response = 'Invalid response format'
                    }
                    $('#response').html(formatJSON(response));
                }());
            </script>
            @endif

            @if (Session::has('errors'))
            <p>Errors:</p>
                @foreach(Session::get('errors')->all() as $error)
                    <p class="errors">{{ $error }}</p>
                @endforeach
            <p></p>
            @endif
        </div>
	</body>
</html>