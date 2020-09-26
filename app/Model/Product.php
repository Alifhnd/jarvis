<?php

namespace App\Model;

use App\Http\Resources\ProductCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Product
 * @package App\Model
 *
 * @property string title
 * @property int price
 * @property string description
 * @property int discount
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "title",
        "locale",
        "price",
        "quantity",
        "description",
        "discount"
    ];

    /**
     * find product by id
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Query\Builder|mixed
     */
    public function findProductById(int $id)
    {
        return $this->find($id);
    }
}
