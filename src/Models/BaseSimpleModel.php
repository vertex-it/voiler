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

abstract class BaseSimpleModel extends Model
{
    use SoftDeletes, LogsActivity;

    protected $guarded = [];

    protected string $titleColumn;

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

    public function getTitle(): ?string
    {
        if ($this->titleColumn === 'id') {
            return Str::of(get_class($this))->afterLast('\\') . ' | ' . $this->id;
        }

        if ($this->titleColumn && $this->titleColumn !== 'id') {
            return strip_tags($this->{$this->titleColumn});
        }

        return null;
    }

    public function getTitleColumn(): string
    {
        return $this->titleColumn;
    }

    public function scopeFindByRouteKeyName($query, $key)
    {
        return $query->where($this->getRouteKeyName(), $key);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
