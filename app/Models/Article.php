<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    public $guarded = [];

    public $appends = ['full_preview_image', 'shortcut_title'];

    /** Accessors And Mutators */
    public function content(): Attribute {
        return Attribute::make(
            get: function() {
                return (array)json_decode($this->attributes['content']);
            },
            set: function($value) {
                return json_encode($value);
            }
        );
    }

    public function fullPreviewImage(): Attribute {
        return Attribute::make(
            get: fn() => Storage::url($this->attributes['preview_image'])
        );
    }

    public function shortcutTitle(): Attribute {
        return Attribute::make(
            get: function() {
                $max_length = 19;
                $title = $this->attributes['title'];
                return (strlen($title) <= $max_length) ? $title : substr($title, 0, 19) . '...';
            }
        );
    }

    /** Relationships */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
