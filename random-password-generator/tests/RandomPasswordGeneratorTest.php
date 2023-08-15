<?php
// random-password-generator/tests/RandomPasswordGeneratorTest.php

namespace Tests\Unit;

use App\Models\AccessCode;
use CodeService\CodeService;
use PHPUnit\Framework\TestCase;
use RandomPasswordGenerator\RandomPasswordGenerator;

class RandomPasswordGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $password = RandomPasswordGenerator::generate();
        $this->assertEquals(6, strlen($password));
    }


    public function testCheckConditions()
    {

        $this->assertFalse(RandomPasswordGenerator::isPalindrome(333444));
        $this->assertTrue(RandomPasswordGenerator::hasRepeatedCharacters(111135, 3));
        $this->assertNotEquals(RandomPasswordGenerator::countUniqueCharacters(663633), 3);
        $this->assertTrue(RandomPasswordGenerator::hasSequentialCharacters(678931, 3));
    }

    /** @test */
    public function it_can_allocate_a_code_to_user()
    {
        $userId = 1;

        $code = CodeService::allocateCodeToUser($userId);

        $this->assertNotNull($code);
        $this->assertTrue(AccessCode::where('user_id', $userId)->exists());
    }

    /** @test */
    public function it_can_reset_an_allocated_code_to_user()
    {
        $userId = 1;
        $initialCode = CodeService::allocateCodeToUser($userId);

        $newCode = CodeService::resetAllocatedCodeToUser($userId);

        $this->assertNotEquals($initialCode, $newCode);
    }

    /** @test */
    public function it_can_check_if_a_code_exists()
    {
        $existingCode = '123456';
        AccessCode::create(['access_code' => $existingCode]);

        $this->assertTrue(CodeService::checkCode($existingCode));
        $this->assertFalse(CodeService::checkCode('987654'));
    }

    /** @test */
    public function it_can_get_an_allocated_code_for_user()
    {
        $userId = 1;
        $code = CodeService::allocateCodeToUser($userId);

        $allocatedCode = CodeService::getAllocateCodeToUser($userId);

        $this->assertEquals($code, $allocatedCode->access_code);
    }

    /** @test */
    public function it_can_delete_an_allocated_code_for_user()
    {
        $userId = 1;
        CodeService::allocateCodeToUser($userId);

        $message = CodeService::deleteAllocateCodeToUser($userId);

        $this->assertNotNull($message);
        $this->assertFalse(AccessCode::where('user_id', $userId)->exists());
    }
}
