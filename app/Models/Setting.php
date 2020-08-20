<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Setting extends Model
{
use Searchable;
        use QueryCacheable;
    public $cacheFor=60*60*24; //cache for 1 day
    protected static $flushCacheOnUpdate=true; //invalidate the cache when the database is changed
protected $fillable = [
        'name',
        'default_value',
        'data_type_id',
    
    ];
    
protected $searchable = [
            'id',
            'name',
            'default_value',
            'data_type_id',
    
    ];
    
    
    
    protected $dates = [
            'created_at',
        'updated_at',
    ];

    protected $appends = ["api_route"];

    public function toSearchableArray() {
        return collect($this->only($this->searchable))->merge([
            // Add more keys here
        ])->toArray();
    }
    
    /* ************************ ACCESSOR ************************* */

    public function getApiRouteAttribute() {
        return route("api.settings.index");
    }
    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    /* ************************ RELATIONS ************************ */
    /**
    * Many to One Relationship to \App\Models\DataType::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function dataType() {
        return $this->belongsTo(\App\Models\DataType::class,"data_type_id","id");
    }
}
