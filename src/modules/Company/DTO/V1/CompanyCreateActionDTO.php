<?php

namespace Modules\Company\DTO\V1;

use App\DTO\BaseActionDTO;
use Illuminate\Support\Str;

class CompanyCreateActionDTO extends BaseActionDTO
{
    public string $name;
    public string $slug;
    public string $location;
    public int $user_id;
    public string $created_at;
    public string $updated_at;

    public function __construct(array $data)
    {
        $this->validateFields(
            ['name', 'location'],
            $data
        );

        $this->name = $data['name'];
        $this->slug = Str::slug($data['name'], '-');;
        $this->location = $data['location'];
        $this->user_id = auth()->user()->id;
        $this->created_at = now();
        $this->updated_at = now();
    }

}
