<?php

namespace VertexIT\Voiler\Models;

use VertexIT\Voiler\Traits\HasCompleteness;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

abstract class BaseModel extends Model implements HasMedia
{
    use SoftDeletes, HasSlug, InteractsWithMedia, HasFactory, LogsActivity, HasCompleteness;

    protected $guarded = [];

    protected $slugMap;

    protected $searchableColumns = [];

    protected $titleColumn;

    protected static $logAttributes = ["*"];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->slugMap ?: $this->titleColumn)
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::created(function ($model) {
            foreach ($model->casts as $columnName => $castType) {
                if (Str::contains($castType, ['RichText', 'MediaSingle', 'MediaMultiple'])) {
                    $model = $model->fresh();
                    $model->EVENT_CREATED = true;
                    $model->{$columnName} = $model->{$columnName};
                    unset($model->EVENT_CREATED);
                    $model->save();
                }
            }
        });
    }

    public function isOwnedByUser($user): bool
    {
        return true;
    }

    public static function createWithRelations(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $model = self::create($request->validated());
            $model->createRelations($request);

            return $model;
        });
    }

    public function updateWithRelations(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $this->update($request->validated());
            $this->updateRelations($request);

            return $this;
        });
    }

    public function forceDeleteWithRelations()
    {
        $this->deleteRelations();

        $this->forceDelete();
    }

    public function createRelations(Request $request): void
    {
        //
    }

    public function updateRelations(Request $request): void
    {
        //
    }

    public function deleteRelations(): void
    {
        //
    }

    public function registerMediaCollections(): void
    {
        foreach ($this->casts as $columnName => $castType) {
            if (Str::contains($castType, ['RichText', 'MediaSingle', 'MediaMultiple'])) {
                $mediaCollection = $this->addMediaCollection($columnName);

                if (Str::contains($castType, ['MediaSingle'])) {
                    $mediaCollection = $mediaCollection->singleFile();
                }

                if (Str::contains($castType, ['Responsive'])) {
                    $mediaCollection = $mediaCollection->withResponsiveImages();
                }
            }
        }
    }

    public function getTitle()
    {
        if ($this->titleColumn) {
            return strip_tags($this->{$this->titleColumn});
        }

        if (is_array($this->slugMap)) {
            $title = '';

            foreach ($this->slugMap as $column) {
                $title .= $this->{$column} . ' ';
            }

            return strip_tags($title);
        }

        if ($this->slugMap) {
            return strip_tags($this->{$this->slugMap});
        }

        return null;
    }

    public function getTitleColumn()
    {
        return $this->titleColumn;
    }

    public function scopeFindByRouteKeyName($query, $key)
    {
        return $query->where($this->getRouteKeyName(), $key);
    }

    public function scopeSearchTable($query, $keyword, $specificColumns = null)
    {
        $searchThrough = $this->searchableColumns;

        if (is_array($specificColumns)) {
            $searchThrough = $specificColumns;
        }

        foreach ($searchThrough as $column) {
            $query = $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
        }

        return $query;
    }

    public function scopeSearchRelation($query, $relation, $keyword)
    {
        return $query->whereHas($relation, function ($q) use ($keyword) {
            $q->searchTable($keyword);
        });
    }
}
