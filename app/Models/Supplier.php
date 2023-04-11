<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'phone', 'address'];

    protected $searchableFields = ['*'];

    public function supplierReturns()
    {
        return $this->hasMany(SupplierReturn::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
