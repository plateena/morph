<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PageContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["title", "content"];

    /**
     * Remove the specified page content from storage.
     *
     * @return bool|null
     */
    public function delete()
    {
        // Detach all associated tags
        $this->tags()->detach();

        // Delete the page content
        return parent::delete();
    }

    /**
     * Get the tags associated with the page content.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
