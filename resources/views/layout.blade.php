<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/hubblescope/favicon.png') }}">

    <meta name="robots" content="noindex, nofollow">

    <title>Hubblescope{{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>

    <!-- Style sheets-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
	<style>
		body{
			background-color: #232429;
			color: #FFF;
		}
	</style>
</head>
<body>
<div id="app" v-cloak>
	<v-app>
		<v-main>
			<v-sheet color="background" class="fill-height">
				<v-container>
					<v-row class="ma-0" align="center">
						<v-col>
							<div class="text-body-1 text-md-h6 font-weight-bold">Hubblescope{{ config('app.name') ? ' - ' . config('app.name') : '' }}</div>
						</v-col>
					</v-row>
					<v-divider></v-divider>
					<Hubblescope></Hubblescope>
				</v-container>
			</v-sheet>
		</v-main>
	</v-app>
</div>
<script>
window.availableModes = @json($availableModes); // customizable in config('hubblescope.modes')
window.hubblescope = @json($scriptVariables);
window.operatorOptions = ["=", "like", ">", ">=", "<", "<=", "!=", "not like"]
</script>

<script src="{{ asset(mix('app.js', 'vendor/hubblescope')) }}"></script>
</body>
</html>
