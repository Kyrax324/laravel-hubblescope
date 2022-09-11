<?php

namespace Microscope\Models;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Telescope\Storage\EntryModel;
use Laravel\Telescope\Storage\EntryQueryOptions;

class TelescopeEntry extends EntryModel
{
	protected $appends = ["telescope_link"];

	// accessors
	public function getTelescopeLinkAttribute()
	{
		$telescope_domain = config("telescope.domain");
		$telescope_path = config("telescope.path");
		$type = Str::plural($this->type);
		return "{$telescope_domain}/{$telescope_path}/{$type}/{$this->uuid}";
	}

	// scopes
	public function scopeWithTags($query, Array $tags)
    {
		return $query->whereIn('uuid', function ($query) use ($tags) {
			$query->select('entry_uuid')->from('telescope_entries_tags');
			foreach ($tags as $tag) {
				$query->whereIn('entry_uuid', function ($query) use ($tag) {
					$query->select('entry_uuid')->from('telescope_entries_tags')->where('tag', trim($tag));
				});
			}
		});
	}

	public function scopeWithField($query, Array $field)
    {
		$key = $field['key'];
		$operator = $field['operator'];

		if(Str::startsWith($field['key'], "content")){
			$key = Str::replace(".", "->", $field['key']);
		}

		return $query->where( $key, $operator, $field['value'] );
	}
}
