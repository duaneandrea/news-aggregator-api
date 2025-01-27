<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    public function source():BelongsTo{
        return $this->belongsTo(Source::class);
    }

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }
}
