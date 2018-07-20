<?php

use GoodLord\TenantAffordability\Infrastructure\Provider\ConsoleProvider;
use GoodLord\TenantAffordability\Infrastructure\Provider\LoggerProvider;

return [
    new ConsoleProvider(),
    new LoggerProvider(),
];
