<?php

namespace Modules\Company\Http\Controllers\V1;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Traits\ApiResponses;
use Modules\Company\Actions\CompanyCreateAction;
use Modules\Company\Actions\CompanyUpdateAction;
use Modules\Company\DTO\V1\CompanyCreateActionDTO;
use Modules\Company\DTO\V1\CompanyUpdateActionDTO;
use Modules\Company\Http\Filters\V1\CompanyFilter;
use Modules\Company\Http\Requests\V1\CompanyStoreRequest;
use Modules\Company\Http\Requests\V1\CompanyUpdateRequest;
use Modules\Company\Http\Resources\V1\CompanyResource;
use Modules\Company\Models\Company;

class CompanyController extends BaseApiController
{

    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(CompanyFilter $filters)
    {
        return CompanyResource::collection(Company::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        return new CompanyResource(
            app(CompanyCreateAction::class)->execute(
                new CompanyCreateActionDTO($request->mappedAttributes())
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        return new CompanyResource(
            app(CompanyUpdateAction::class)->execute(
                new CompanyUpdateActionDTO($request->mappedAttributes()),
                $company
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return $this->ok('Company successfully deleted');
    }
}
