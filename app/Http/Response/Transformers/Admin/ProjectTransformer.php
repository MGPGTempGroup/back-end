<?php

namespace App\Http\Response\Transformers\Admin;

use App\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'agents', 'creator', 'productTypes'
    ];

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'location' => $project->location,
            'address' => $project->address,
            'introduction' => $project->introduction,
            'description' => $project->description,
            'year_built' => $project->year_built,
            'broadcast_pictures' => $project->broadcast_pictures,
            'created_at' => $project->created_at->toDateTimeString(),
            'updated_at' => $project->updated_at->toDateTimeString()
        ];
    }

    public function includeAgents(Project $project)
    {
        return $this->collection($project->agents, new CompanyMemberTransformer());
    }

    public function includeCreator(Project $project)
    {
        return $this->item($project->creator, new AdminUserTransformer());
    }

    public function includeProductTypes(Project $project)
    {
        return $this->collection($project->productTypes, new ProductTypeTransformer());
    }

}
