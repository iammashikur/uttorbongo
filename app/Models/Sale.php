<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'product_id',
        'product_code_id',
        'buyer_id',
        'purchase_price',
        'sale_price',
        'user_id',
        'shop_id',
    ];

    protected $searchableFields = ['*'];

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
