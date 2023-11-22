<?php

namespace VertexIT\Voiler\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use VertexIT\Voiler\Traits\HasCompleteness;

abstract class BaseModel extends BaseSimpleModel implements HasMedia
{
    use HasSlug, InteractsWithMedia, HasFactory, HasCompleteness;

    protected array | string $slugMap;

    protected array $searchableColumns = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->slugMap ?? $this->titleColumn)
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::created(static function ($model) {
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

    public function isOwnedByUser(User $user): bool
    {
        return true;
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
