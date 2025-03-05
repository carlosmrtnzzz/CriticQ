<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Follower;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    public function run(): void
    {
        $users = Usuario::all();
        $userIds = $users->pluck('id')->toArray();

        foreach ($users as $user) {

            $followCount = rand(1, 8);
            $potentialFollowIds = array_diff($userIds, [$user->id]);

            if (count($potentialFollowIds) > 0) {
                $randomFollowIds = array_rand(array_flip($potentialFollowIds), min($followCount, count($potentialFollowIds)));

                if (!is_array($randomFollowIds)) {
                    $randomFollowIds = [$randomFollowIds];
                }

                foreach ($randomFollowIds as $followId) {
                    Follower::create([
                        'seguidor_id' => $user->id,
                        'seguido_id' => $followId,
                        'estado' => 'aceptado',
                    ]);
                }
            }
        }
    }
}