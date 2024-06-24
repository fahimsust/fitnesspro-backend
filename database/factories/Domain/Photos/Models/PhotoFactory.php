<?php

namespace Database\Factories\Domain\Photos\Models;

use Domain\Accounts\Models\Account;
use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'addedby' => function () {
                return Account::firstOrFactory()->id;
            },
            'added' => now(),
            'title' => $this->faker->words(3, true),
            'img' => '9a8dee811c7165dbd5ba10185335c0fd.png',
            'album' => function () {
                return PhotoAlbum::firstOrFactory()->id;
            },
            'approved' => true,
        ];
    }
}
