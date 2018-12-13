<?php

namespace App\Http\Response\Transformers\Admin;

use App\HouseInspection;
use League\Fractal\TransformerAbstract;

class HouseInspectionTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'house', 'followUp'
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
            'mobile_from_country' => $houseInspection->mobile_from_country,
            'email' => $houseInspection->email,
            'comment' => $houseInspection->comment,
            'preferred_inspection_datetime' => $houseInspection->preferred_inspection_datetime,
            'preferred_move_in_date' => $houseInspection->preferred_move_in_date,
            'surname' => $houseInspection->surname,
            'first_name' => $houseInspection->first_name,
            'name' => $houseInspection->first_name,
            'type' => $houseType,
            'is_follow_up' => (boolean) $houseInspection->follow_up,
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

    public function includeFollowUp(HouseInspection $houseInspection)
    {
        if ($followUp = $houseInspection->followUp) {
            return $this->item($followUp, new AdminUserTransformer());
        }
        return $this->null();
    }

}
