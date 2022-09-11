<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/microscope/favicon.png') }}">

    <meta name="robots" content="noindex, nofollow">

    <title>Microscope{{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<script src="{{ asset(mix('app.js', 'vendor/microscope')) }}" defer></script>
</head>
<body>
<div id="app">
	<v-app>
		<v-main>
			<v-sheet color="background" class="fill-height">
				<v-container>
					<v-row class="ma-0" align="center">
						<v-col>
							<div class="text-body-1 text-md-h6 font-weight-bold">Microscope{{ config('app.name') ? ' - ' . config('app.name') : '' }}</div>
						</v-col>
					</v-row>
					<v-divider></v-divider>
					<Microscope></Microscope>
				</v-container>
			</v-sheet>
		</v-main>
	</v-app>
</div>
<script>
window.shortcutSuggestions = [
	{  text: "URI", key: "content.uri", value: "", operator : "like" },
	{  text: "Method", key: "content.method", value: "", operator : "=" },
	{  text: "Http Code", key: "content.response_status", value: "", operator : "=" },
	{  text: "Domain", key: "content.headers.host", value: "", operator : "like" },
]

window.opertionOptions = ["=", "like", ">", ">=", "<", "<=", "!=", "not like"]
</script>
</body>
</html>
