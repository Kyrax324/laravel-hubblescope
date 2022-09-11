<?php

namespace Microscope\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use Microscope\Http\Requests\DumpQueryRequest;
use Microscope\Http\Requests\SearchRequest;
use Microscope\Models\TelescopeEntry;

class MainController extends Controller
{
	public function index()
	{
		return view("microscope::layout");
	}

	public function search(SearchRequest $request)
	{
		$query = TelescopeEntry::query();
		$result = $this->buildQuery($query, $request)
			->paginate($request->itemsPerPage);

		return response()->json([
			"message" => "Success",
			"data" => $result,
		]);
	}

	public function dumpQuery(DumpQueryRequest $request)
	{
		$query = TelescopeEntry::query();
		$query = $this->buildQuery($query, $request);

		$result = self::getSql($query);

		return response()->json([
			"message" => "Success",
			"data" => $result,
		]);
	}

	protected function buildQuery($query, $request)
	{
		$tags = array_filter(explode(',', $request->tags));
		$fields = $request->fields;

		return $query->where("type", "request")
			->when($tags, function($q) use ($tags){
				$q->withTags($tags);
			})
			->when($fields, function($q) use ($fields){
				foreach ($fields as $field){
					$q->withField($field);
				}
			})
			->latest();
	}

	public static function getSql(Builder $builder)
	{
		$addSlashes = str_replace('?', "'?'", $builder->toSql());
		return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
	}
}
