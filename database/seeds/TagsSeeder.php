<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ru_RU');
        for ($i = 1; $i <= 10; $i++) {
            $form = collect([
                'name' => str_replace(' ', '', $faker->company),
            ]);
            \App\Eloquent\Tags::create($form->toArray());
        }
    }
}
