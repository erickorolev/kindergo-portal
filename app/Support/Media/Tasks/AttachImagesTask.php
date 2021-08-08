<?php

declare(strict_types=1);

namespace Support\Media\Tasks;

use Domains\TemporaryFile\Actions\FindAndAttachFileAction;
use Domains\Trips\DataTransferObjects\TripData;
use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Models\User;
use Parents\DataTransferObjects\ObjectData;
use Parents\Models\Model;
use Parents\ValueObjects\UrlValueObject;
use Spatie\MediaLibrary\HasMedia;

final class AttachImagesTask extends \Parents\Tasks\Task
{
    /**
     * @param  User  $user
     * @param  UserData|TripData  $userData
     * @param  string  $collection
     * @return User|Model
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @psalm-suppress UndefinedPropertyFetch
     */
    public function handle(HasMedia $user, ObjectData $userData, string $collection = 'avatar'): User|Model
    {
        if (property_exists($userData, 'avatar_path') && $userData->avatar_path) {
            $user->addMedia($userData->avatar_path)
                ->toMediaCollection($collection);
        }
        if (property_exists($userData, 'file') && $userData->file) {
            FindAndAttachFileAction::run($userData->file, $user, $collection);
        }
        if (property_exists($userData, 'external_file') && !$userData->external_file->isNull()) {
            $user->addMediaFromUrl($userData->external_file->toNative())->toMediaCollection($collection);
        }

        if (property_exists($userData, 'files') && $userData->files) {
            foreach ($userData->files as $file) {
                FindAndAttachFileAction::run($file, $user, $collection);
            }
        }
        if (property_exists($userData, 'documents') && $userData->documents) {
            foreach ($userData->documents as $document) {
                $user->addMedia($document)
                    ->toMediaCollection($collection);
            }
        }
        if (property_exists($userData, 'external_files') && $userData->external_files) {
            foreach ($userData->external_files as $external_file) {
                $user->addMediaFromUrl($external_file->toNative())->toMediaCollection($collection);
            }
        }
        if (!empty($userData->documents)) {
            /** @var UrlValueObject $document */
            foreach ($userData->documents as $document) {
                $user->addMediaFromUrl($document->toNative())->toMediaCollection('documents');
            }
        }
        return $user;
    }
}
