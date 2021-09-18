<?php

declare(strict_types=1);

namespace Domains\Payments\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Payments\Enums\AttendantSignatureEnum;
use Domains\Payments\Enums\PayTypeEnum;
use Domains\Payments\Enums\SpStatusEnum;
use Domains\Payments\Enums\TypePaymentEnum;
use Domains\Payments\Http\Controllers\Api\PaymentApiController;
use Domains\Payments\Http\Requests\Admin\DeletePaymentRequest;
use Domains\Payments\Http\Requests\Admin\IndexPaymentRequest;
use Domains\Payments\Http\Requests\Api\PaymentStoreApiRequest;
use Domains\Payments\Http\Requests\Api\PaymentUpdateApiRequest;
use Domains\Payments\Jobs\SendPaymentToVtigerJob;
use Domains\Payments\Models\Payment;
use Domains\Payments\Repositories\Eloquent\PaymentRepository;
use Domains\Payments\Repositories\PaymentRepositoryInterface;
use Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Parents\Tests\PhpUnit\TestCase;

class PaymentApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use AdditionalAssertions;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_payments_list(): void
    {
        Payment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.payments.index'));

        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 5, fn(AssertableJson $json) =>
            $json
                ->where('type', 'payments')
                ->hasAll([
                    'id',
                    'attributes',
                    'type',
                    'attributes.pay_date',
                    'attributes.amount',
                    'attributes.pay_type',
                    'attributes.spstatus',
                    'attributes.crmid',
                    'attributes.attendanta_signature',
                    'attributes.attendanta_signature.value',
                    'attributes.pay_type.value',
                    'attributes.spstatus.value'
                ])->etc())->etc());
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_payment(): void
    {
        Bus::fake();
        $data = Payment::factory()
            ->make()
            ->toArray();
        $data['pay_date'] = '2021-10-08';

        try {
            $response = $this->postJson(route('api.payments.store'), [
                'data' => [
                    'type' => 'payments',
                    'attributes' => $data
                ]
            ]);
            $response->assertStatus(201)->assertJson([
                'data' => [
                    'type' => 'payments',
                    'attributes' => [

                    ]
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dump($e->errors());
            $this->assertTrue(false, $e->getMessage());
        }
        $data['amount'] = $data['amount'] * 100;
//        Bus::assertDispatched(SendPaymentToVtigerJob::class);
        $this->assertDatabaseHas('payments', $data);
    }

    /**
     * @test
     */
    public function it_updates_the_payment(): void
    {
        Bus::fake();
        /** @var Payment $payment */
        $payment = Payment::factory()->create();
        /** @var User $user */
        $user = User::factory()->create();

        $data = [
            'pay_date' => '2021-08-05',
            'pay_type' => PayTypeEnum::getRandomValue(),
            'amount' => $this->faker->randomNumber(),
            'spstatus' => SpStatusEnum::getRandomValue(),
            'user_id' => $user->id,
            'assigned_user_id' => '19x1',
            'attendanta_signature' => AttendantSignatureEnum::getRandomValue()
        ];

        $response = $this->putJson(
            route('api.payments.update', $payment->id),
            [
                'data' => [
                    'type' => 'payments',
                    'id' => (string) $payment->id,
                    'attributes' => $data
                ]
            ]
        );

        $data['id'] = $payment->id;
        $data['amount'] = $data['amount'] * 100;
        $this->assertDatabaseHas('payments', $data);

        $response->assertStatus(202)->assertJson([
            'data' => [
                'type' => 'payments',
                'id' => (string) $payment->id,
                'attributes' => []
            ]
        ]);
        Bus::assertDispatched(SendPaymentToVtigerJob::class);
    }

    /**
     * @test
     */
    public function it_deletes_the_payment(): void
    {
        /** @var Payment $payment */
        $payment = Payment::factory()->create();

        $response = $this->deleteJson(route('api.payments.destroy', $payment->id));
        $payment->refresh();
        $response->assertNoContent();

        $this->assertSoftDeleted($payment);
    }

    /**
     * @test
     */
    public function it_uses_correct_repository(): void
    {
        $repModel = app(PaymentRepositoryInterface::class);
        $this->assertInstanceOf(PaymentRepository::class, $repModel);
    }

    /**
     * @test
     */
    public function it_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.payments.index', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_uses_index_request(): void
    {
        $this->assertActionUsesFormRequest(
            PaymentApiController::class,
            'index',
            IndexPaymentRequest::class
        );
    }

    /**
     * @test
     */
    public function store_payment_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            PaymentApiController::class,
            'store',
            PaymentStoreApiRequest::class
        );
    }

    /**
     * @test
     */
    public function update_uses_request(): void
    {
        $this->assertActionUsesFormRequest(
            PaymentApiController::class,
            'update',
            PaymentUpdateApiRequest::class
        );
    }

    /**
     * @test
     */
    public function delete_uses_request(): void
    {
        $this->assertActionUsesFormRequest(
            PaymentApiController::class,
            'destroy',
            DeletePaymentRequest::class
        );
    }
}
