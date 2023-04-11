<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCode extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['product_id', 'product_code'];

    protected $searchableFields = ['*'];

    protected $table = 'product_codes';

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function dues()
    {
        return $this->hasMany(Due::class);
    }

    public function product(){
        return $this->hasOne(Product::class);
    }
}
