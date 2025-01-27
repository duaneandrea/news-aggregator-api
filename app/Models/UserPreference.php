<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPreference extends Model
{
    use SoftDeletes;

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function source():BelongsTo{
        return $this->belongsTo(Source::class);
    }

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }
}
