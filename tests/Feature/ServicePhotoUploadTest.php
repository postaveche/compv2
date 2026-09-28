<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServicePhotoUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        $this->withoutMiddleware(\App\Http\Middleware\Authenticate::class);
        Storage::fake('public');
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
        });
        Schema::create('service_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('image');
            $table->string('description')->nullable();
            $table->string('stage');
            $table->timestamps();
        });
        DB::table('service_orders')->insert(['id' => 1, 'order_number' => 'SC-TEST']);
    }

    public function test_mobile_sized_photos_with_identical_names_are_stored_separately()
    {
        $this->postJson(route('service.photos.add', 1), [
            'stage' => 'received',
            'photos' => [
                UploadedFile::fake()->image('image.jpg')->size(8192),
                UploadedFile::fake()->image('image.jpg')->size(6144),
            ],
        ])->assertOk();

        $photos = DB::table('service_photos')->get();
        $this->assertCount(2, $photos);
        $this->assertNotSame($photos[0]->image, $photos[1]->image);
        foreach ($photos as $photo) {
            Storage::disk('public')->assertExists('service/'.$photo->image);
        }
    }

    public function test_missing_files_are_rejected()
    {
        $this->postJson(route('service.photos.add', 1), ['stage' => 'received'])
            ->assertStatus(422)->assertJsonValidationErrors('photos');
        $this->assertSame(0, DB::table('service_photos')->count());
    }

    public function test_oversized_files_and_unsupported_formats_are_rejected()
    {
        $this->postJson(route('service.photos.add', 1), [
            'stage' => 'received',
            'photos' => [UploadedFile::fake()->image('large.jpg')->size(20481)],
        ])->assertStatus(422)->assertJsonValidationErrors('photos.0');
        $this->postJson(route('service.photos.add', 1), [
            'stage' => 'received',
            'photos' => [UploadedFile::fake()->create('photo.heic', 100, 'image/heic')],
        ])->assertStatus(422)->assertJsonValidationErrors('photos.0');
        $this->assertSame(0, DB::table('service_photos')->count());
    }

    public function test_failed_storage_does_not_create_a_photo_record()
    {
        // Simulate a write failure without relying on filesystem permissions.
        Storage::shouldReceive('disk')->with('public')->andReturn($disk = \Mockery::mock());
        $disk->shouldReceive('putFileAs')->once()->andReturn(false);

        $this->postJson(route('service.photos.add', 1), [
            'stage' => 'received',
            'photos' => [UploadedFile::fake()->image('image.jpg')],
        ])->assertStatus(422)->assertJsonValidationErrors('photos');
        $this->assertSame(0, DB::table('service_photos')->count());
    }
}
