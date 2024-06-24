<?php

namespace Tests;

abstract class UnitTestCase extends TestCase
{


    protected function isHtml($content)
    {
        return $content != strip_tags($content);
    }
}
