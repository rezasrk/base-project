<?php

namespace Tests\Unit\App\Services\General\Support;

use App\Services\General\Support\StrongPasswordService;
use Tests\Unit\BaseUnitTestCase;

final class StrongPasswordServiceTest extends BaseUnitTestCase
{
    /** 
     * @test 
     * @dataProvider strongPasswordProvider
     */
    public function strong_password_can_get_true_when_password_is_strong(string $password)
    {
        $this->assertTrue(StrongPasswordService::check($password));
    }

    /**
     * @test
     * @dataProvider weakPasswordProvider
     */
    public function strong_password_can_get_false_when_password_is_weak(string $password)
    {
        $this->assertFalse(StrongPasswordService::check($password));
    }

    public static function strongPasswordProvider()
    {
        return [
            ['Ad114785'],
            ['dA169854'],
            ['4Ad85214'],
            ['4Adkdngj'],
            ['4dASKDJK'],
            ['Skdjc23584alk'],
        ];
    }

    public static function weakPasswordProvider()
    {
        return [
            ['AAAAAAAA'],
            ['aaaaaaaa'],
            ['11111111'],
            ['Aa1'],
            ['AaaaaaAA'],
            ['1aaaaa11'],
            ['1AAAAAA1'],
        ];
    }
}
