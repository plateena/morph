<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * Get the page contents associated with the tag.
     */
    public function pageContents(): BelongsToMany
    {
        return $this->belongsToMany(PageContent::class);
    }
}
