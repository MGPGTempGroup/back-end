<?php

namespace App\Http\Response\Transformers\Admin;

use App\HouseInspection;
use League\Fractal\TransformerAbstract;

class HouseInspectionTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'house', 'followUp', 'remarks'
    ];

    public function transform(HouseInspection $houseInspection)
    {
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
            'type' => $houseInspection->house_type,
            'is_follow_up' => (boolean) $houseInspection->follow_up,
            'created_at' => $houseInspection->created_at->toDateTimeString(),
            'updated_at' => $houseInspection->updated_at->toDateTimeString()
        ];
    }

    public function includeHouse(HouseInspection $houseInspection)
    {
        if ($leaseHouse = $houseInspection->house) {
            $transformer = [
                'residences' => ResidenceTransformer::class,
                'leases' => LeaseTransformer::class
            ][$houseInspection->house_type];
            return $this->item($leaseHouse, new $transformer);
        }
        return $this->null();
    }

    public function includeFollowUp(HouseInspection $houseInspection)
    {
        if ($followUp = $houseInspection->followUp) {
            return $this->item($followUp, new AdminUserTransformer());
        }
        return $this->null();
    }

    public function includeRemarks(HouseInspection $houseInspection)
    {
        $remarks = $houseInspection->remarks;
        if ($remarks) {
            return $this->collection($remarks, new RemarkTransformer());
        }
        return $this->null();
    }

}
