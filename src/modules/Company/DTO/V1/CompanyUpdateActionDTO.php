<?php

namespace Modules\Company\DTO\V1;

use App\DTO\BaseActionDTO;
use Illuminate\Support\Str;

class CompanyUpdateActionDTO extends BaseActionDTO
{
    public ?string $name;
    public ?string $slug;
    public ?string $location;
    public ?int $user_id;
    public string $updated_at;


    public function __construct(array $data)
    {
        if (isset($data['name'])) {
            $this->name = $data['name'];
            $this->slug = Str::slug($data['name'], '-');
        }
        if (isset($data['location'])) {
            $this->location = $data['location'];
        }
        if (isset($data['user_id'])) {
            $this->user_id = $data['user_id'];
        }
        $this->updated_at = now();
    }

}
