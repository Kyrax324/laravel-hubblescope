<?php

return [
    'path' => env('HUBBLESCOPE_PATH', 'hubblescope'),

	'domain' => env("HUBBLESCOPE_DOMAIN", null),

	'middleware' => "telescope", // the middleware-group registered in telescope

	/**
     * Available mode for the interaction UI
     *
	 * format:
	 * [
	 * 		"value" => "", // the telescope entity types eg: request, query, ...
	 * 		"text" => "", // display text
	 * 		"headers" => "", // An array of objects that each describe a header column. See the example below for a definition of all properties, see https://vuetifyjs.com/en/api/v-data-table/#props-headers
	 * 		"shortcuts" => "", // short option for auto-filling
	 * ]
     */
	'modes' => [
		[
			"value" => "request",
			"text" => "Request",
			"headers" => [
				["text" => "Method", "value" => "content.method"],
				["text" => "Path", "value" => "content.uri"],
				["text" => "Status", "value" => "content.response_status"],
			],
			"shortcuts" => [
				[
					"text" => "URI",
					"key" => "content.uri",
					"value" => "",
					"operator" => "like",
				],
				[
					"text" => "Method",
					"key" => "content.method",
					"value" => "",
					"operator" => "=",
				],
				[
					"text" => "Http Code",
					"key" => "content.response_status",
					"value" => "",
					"operator" => "=",
				],
				[
					"text" => "Domain",
					"key" => "content.headers.host",
					"value" => "",
					"operator" => "like",
				],
			],
		],
		[
			"value" => "query",
			"text" => "Query",
			"headers" => [
				["text" => "Sql", "value" => "content.sql"]
			],
			"shortcuts" => [
				[
					"text" => "sql",
					"key" => "content.sql",
					"value" => "",
					"operator" => "like",
				],
				[
					"text" => "slow",
					"key" => "content.slow",
					"value" => "(bool)true",
					"operator" => "=",
				],
			],
		],
		[
			"value" => "client_request",
			"text" => "HTTP Client",
			"headers" => [
				["text" => "Method", "value" => "content.method"],
				["text" => "Path", "value" => "content.uri"],
				["text" => "Status", "value" => "content.response_status"],
			],
			"shortcuts" => [
				[
					"text" => "URI",
					"key" => "content.uri",
					"value" => "",
					"operator" => "like",
				],
				[
					"text" => "Method",
					"key" => "content.method",
					"value" => "",
					"operator" => "=",
				],
				[
					"text" => "Http Code",
					"key" => "content.response_status",
					"value" => "",
					"operator" => "=",
				],
			],
		],
	]
];