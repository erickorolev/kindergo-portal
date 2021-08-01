<?php

declare(strict_types=1);

namespace Domains\Users\Tests\Unit;

use Domains\Users\ValueObjects\PasswordValueObject;
use Illuminate\Support\Facades\Hash;

class PasswordValueObjectTest extends \Parents\Tests\PhpUnit\TestCase
{

    public function testComparingValuesFalse(): void
    {
        $object1 = PasswordValueObject::fromNative('test');
        $object2 = PasswordValueObject::fromNative('test2');
        $this->assertFalse($object1->sameValueAs($object2));
    }
}
