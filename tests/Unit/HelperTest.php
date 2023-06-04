<?php

namespace Tests\Unit;

use App\support\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_byte_convert(): void
    {
        $byte = Helper::bytesConverter("1024");
        $this->assertEquals("1 KB", $byte);
        print $byte;
    }

    public function test_sort_text() :void
    {
        $text = 'Hallo nama saya ar. wahyu pradana';
        $sort = Helper::sortText($text, 10);
        $this->assertEquals("Hallo nama...", $sort);
        print $sort;
    }
}
