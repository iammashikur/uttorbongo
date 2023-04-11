<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Due extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'buyer_id',
        'product_id',
        'product_code_id',
        'due_amount',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
