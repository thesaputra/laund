<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laundry</title>

	<link href="{{ asset('css/general.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/typeahead.css') }}" rel="stylesheet">

	<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">

	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/general.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>

	<script src="{{ asset('js/datetimepicker.js') }}"></script>

	<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>


	<script src="{{ asset('locales/bootstrap-datepicker.id.min.js') }}"></script>

	<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>



	@yield('styles')

	<link rel="shortcut icon" href="{!! asset('assets/site/ico/favicon.ico')  !!} ">
</head>
<body>
	@include('layouts.partials.nav')

	<div class="container">
		@include('layouts.partials.alerts.errors')
		@include('layouts.partials.alerts.success')

		@yield('content')

		@include('layouts.partials.footer')
	</div>
	<!-- Scripts -->
	@yield('scripts')
</body>
</html>
