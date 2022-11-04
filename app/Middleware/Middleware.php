<?php

namespace Reedb\PhpMvc\Middleware;

interface Middleware{

    function before(): void;
}