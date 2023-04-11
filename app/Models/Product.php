<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'image',
        'product_category_id',
        'supplier_id',
        'seller_id',
        'shop_id',
        'brand_id',
        'purchase_price',
        'price',
        'details',
        'product_type',
        'show_on_website',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'show_on_website' => 'boolean',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplierReturns()
    {
        return $this->hasMany(SupplierReturn::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function dues()
    {
        return $this->hasMany(Due::class);
    }

    public function products(){
        return $this->hasMany(ProductCode::class);

    }

    public function productCodes()
    {
        return $this->hasMany(ProductCode::class)->where('status', 0);
    }

}
