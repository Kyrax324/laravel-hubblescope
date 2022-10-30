<?php

namespace Hubblescope\Http\Controllers;

use Illuminate\Routing\Controller;
use Hubblescope\Http\Requests\DumpQueryRequest;
use Hubblescope\Http\Requests\SearchRequest;
use Hubblescope\Http\Services\MainService;
use Hubblescope\Models\TelescopeEntry;

class MainController extends Controller
{
	public function index()
	{
		$hubblescopeScriptVariables = [
			"prefix" => config("hubblescope.path"),
		];
		$availableModes = config("hubblescope.modes");

		return view("hubblescope::layout", [
			"scriptVariables" => $hubblescopeScriptVariables,
			"availableModes" => $availableModes,
		]);
	}

	public function search(SearchRequest $request)
	{
		$query = TelescopeEntry::query();
		$query = MainService::buildQuery($query, $request);

		$result = $query->paginate($request->itemsPerPage);

		return response()->json([
			"message" => "Success",
			"data" => $result,
		]);
	}

	public function dumpQuery(DumpQueryRequest $request)
	{
		$query = TelescopeEntry::query();
		$query = MainService::buildQuery($query, $request);

		$result = MainService::getSql($query);

		return response()->json([
			"message" => "Success",
			"data" => $result,
		]);
	}
}
