<?php

namespace App\Http\Response\Transformers\Admin;

use App\HouseInspection;
use League\Fractal\TransformerAbstract;

class HouseInspectionTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'house'
    ];

    public function transform(HouseInspection $houseInspection)
    {
        $houseType = [
            'App\Residence' => 'sale',
            'App\Lease' => 'lease'
        ][$houseInspection->house_type];
        return [
            'id' => $houseInspection->id,
            'mobile' => $houseInspection->mobile,
            'comment' => $houseInspection->comment,
            'inspection_date' => $houseInspection->inspection_date,
            'inspection_time' => $houseInspection->inspection_time,
            'surname' => $houseInspection->surname,
            'first_name' => $houseInspection->first_name,
            'name' => $houseInspection->first_name,
            'type' => $houseType,
            'created_at' => $houseInspection->created_at->toDateTimeString(),
            'updated_at' => $houseInspection->updated_at->toDateTimeString()
        ];
    }

    public function includeHouse(HouseInspection $houseInspection)
    {
        $transformer = [
            'App\Residence' => ResidenceTransformer::class,
            'App\Lease' => LeaseTransformer::class
        ][$houseInspection->house_type];
        return $this->item($houseInspection->house, new $transformer);
    }

}
