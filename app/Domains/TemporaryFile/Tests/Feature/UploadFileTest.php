<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Tests\Feature;

use Domains\TemporaryFile\Actions\FindAndAttachFileAction;
use Domains\TemporaryFile\Actions\UploadFileAction;
use Illuminate\Http\UploadedFile;

class UploadFileTest extends \Parents\Tests\PhpUnit\TestCase
{
    /**
     * @test
     * @see UploadFileAction
     */
    public function testFileUploadAction(): void
    {
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');
        $action = app(UploadFileAction::class);
        $result = $action($file);
        $this->assertFileExists(storage_path('app/public/uploads/tmp/' . $result . '/test.pdf'));
        $this->assertNotEquals('', $result);
        $this->assertDatabaseHas('temporary_files', [
            'folder' => $result
        ]);
    }
}
