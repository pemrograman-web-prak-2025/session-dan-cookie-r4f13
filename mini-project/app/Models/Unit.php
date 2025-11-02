<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name', 'leader_id', 'image_url', 'parent_id', 'description', 'location'
    ];

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }

    public function leader()
    {
        return $this->belongsTo(Leader::class, 'leader_id');
    }

    public function toNestedArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'leader' => $this->leader ? $this->leader->name : null,
            'image_url' => $this->image_url,
            'children' => $this->children->map(fn($child) => $child->toNestedArray())->toArray(),
        ];
    }
}
