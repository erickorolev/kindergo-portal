<?php

declare(strict_types=1);

namespace Domains\Children\Tests\Feature;

use Domains\Children\Actions\GetChildByCrmIdAction;
use Domains\Children\Actions\GetChildrenIdsFromArrayAction;
use Domains\Children\Models\Child;
use Parents\Exceptions\NotFoundException;
use Parents\Tests\PhpUnit\TestCase;
use Parents\ValueObjects\CrmIdValueObject;

class ChildrenActionsTest extends TestCase
{
    /**
     * @test
     * @covers \Domains\Children\Actions\GetChildByCrmIdAction
     */
    public function testGettingChildrenByCrmId(): void
    {
        Child::factory()->count(2)->create();
        $child = Child::factory()->createOne([
            'crmid' => '23x112'
        ]);
        /** @var Child $result */
        $result = GetChildByCrmIdAction::run(CrmIdValueObject::fromNative('23x112'));
        $this->assertEquals($child->id, $result->id);
        $result = GetChildByCrmIdAction::run(CrmIdValueObject::fromNative('23x222'));
        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \Domains\Children\Actions\GetChildrenIdsFromArrayAction
     */
    public function testGetChildrenIdsFromArray(): void
    {
        /** @var Child[] $children */
        $children = Child::factory()->count(5)->create();
        $result = GetChildrenIdsFromArrayAction::run([$children[2]->id, $children[3]->id]);
        $this->assertEquals($children[2]->id, $result[0]);
        $this->assertEquals($children[3]->id, $result[1]);
        $result = GetChildrenIdsFromArrayAction::run([$children[2]->crmid, $children[3]->crmid]);
        $this->assertEquals($children[2]->id, $result[0]);
        $this->assertEquals($children[3]->id, $result[1]);
    }
}
