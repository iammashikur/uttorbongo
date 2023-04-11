<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'address', 'phone', 'email', 'document'];

    protected $searchableFields = ['*'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function dues()
    {
        return $this->hasMany(Due::class);
    }
}
