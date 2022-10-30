<?php

namespace Hubblescope\Http\Services;

use Illuminate\Database\Eloquent\Builder;

class MainService
{
	public static function buildQuery($query, $request)
	{
		$tags = array_filter(explode(',', $request->tags));
		$fields = $request->fields;

		return $query->where("type", $request->type)
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
