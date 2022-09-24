<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    public $guarded = [];

    /** Accessors And Mutators */
    public function content(): Attribute {
        return Attribute::make(
            get: function() {
                return (array)json_decode($this->content);
            },
            set: function($value) {
                return json_encode($value);
            }
        );
    }
}
