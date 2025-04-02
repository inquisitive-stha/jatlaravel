<?php

use Modules\Company\Providers\CompanyServiceProvider;
use Modules\JatAuth\Providers\JatAuthServiceProvider;
use Modules\JobApplication\Providers\JobApplicationServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    JatAuthServiceProvider::class,
    CompanyServiceProvider::class,
    JobApplicationServiceProvider::class,
];
