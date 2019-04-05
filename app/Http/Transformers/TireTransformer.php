<?php
namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Tire;

class TireTransformer extends TransformerAbstract{
    protected $availableIncludes = [
    ];

    protected $defaultIncludes = [
        // 'user'
    ];
    

    /**
     * Turn User object into a generic array.
     *
     * @return array
     */
    public function transform(Tire $tire)
    {
        return [
            'id' => $tire->id,
            "created_by"=>$tire->created_by,
            "posistion"=>$tire->posistion,
            "merek"=>$tire->merek,
            "buy_date"=>$tire->buy_date,
            "getUser"=>$tire->getUser
        ];
    }

}