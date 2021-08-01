<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\TemporaryFile\Actions\FindAndAttachFileAction;
use Domains\TemporaryFile\Actions\UploadFileAction;
use Domains\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ReceivingFileTest extends \Parents\Tests\PhpUnit\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'phone' => '+79067598835',
            'otherphone' => '+79087756389'
        ]);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    public function testGetAndAttachFileToModel(): void
    {
        /** @var User $user */
        $user = User::first();
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');
        $action = app(UploadFileAction::class);
        $folder = $action($file);
        $action = app(FindAndAttachFileAction::class);
        $result = $action($folder, $user);
        $user->refresh();
        $this->assertTrue($result);
        $media = $user->getFirstMedia('avatar');
        $this->assertInstanceOf(Media::class, $media);
        $this->assertEquals('test.pdf', $media->file_name);
    }
}
