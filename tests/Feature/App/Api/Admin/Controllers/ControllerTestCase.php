<?php

namespace Tests\Feature\App\Api\Admin\Controllers;

use Tests\Feature\Traits\HasTestAdminUser;
use Tests\Feature\Traits\CreateProductForBulkEdit;
use Tests\TestCase;

abstract class ControllerTestCase extends TestCase
{
    use HasTestAdminUser;
    use CreateProductForBulkEdit;
}
