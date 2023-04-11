<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'address'];

    protected $searchableFields = ['*'];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
