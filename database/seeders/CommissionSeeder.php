<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get client and artist IDs
        $clientIds = DB::table('members')->where('role', 'client')->pluck('member_id')->toArray();
        $artist = DB::table('members')->where('role', 'artist')->first();
        $artistId = $artist ? $artist->member_id : null;

        // Allowed enum values (match migration)
        $categories = ['headshot', 'bustup', 'halfbody', 'fullbody', 'cartoon_bustup', 'cartoon_halfbody', 'cartoon_fullbody'];
        $backgroundTypes = ['none', 'simple', 'detailed'];
        $paymentStatuses = ['pending', 'dp', 'paid', 'refunded'];
        $progressStatuses = ['pending', 'accepted', 'declined', 'in_progress_sketch', 'in_progress_coloring', 'review', 'revision', 'completed', 'cancelled'];

        // Define realistic commission scenarios
        $scenarios = [
            // Scenario 1: New pending commissions (just submitted)
            [
                'progress_status' => 'pending',
                'payment_status' => 'pending',
                'started_at' => null,
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 2: Accepted, waiting for DP payment
            [
                'progress_status' => 'accepted',
                'payment_status' => 'pending',
                'started_at' => null,
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 3: DP paid, artist working on sketch
            [
                'progress_status' => 'in_progress_sketch',
                'payment_status' => 'dp',
                'started_at' => '-1 week to -1 day',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 4
            ],
            // Scenario 4: Sketch under review
            [
                'progress_status' => 'review',
                'payment_status' => 'dp',
                'started_at' => '-2 weeks to -1 week',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 5: In revision (customer requested changes)
            [
                'progress_status' => 'revision',
                'payment_status' => 'dp',
                'started_at' => '-3 weeks to -2 weeks',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 6: Coloring in progress (sketch approved)
            [
                'progress_status' => 'in_progress_coloring',
                'payment_status' => 'dp',
                'started_at' => '-3 weeks to -2 weeks',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 3
            ],
            // Scenario 7: Completed and fully paid
            [
                'progress_status' => 'completed',
                'payment_status' => 'paid',
                'started_at' => '-2 months to -1 month',
                'completed_at' => '-2 weeks to -1 week',
                'fully_paid_at' => '-1 week to -1 day',
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 8: Completed but awaiting full payment
            [
                'progress_status' => 'completed',
                'payment_status' => 'dp',
                'started_at' => '-1 month to -2 weeks',
                'completed_at' => '-1 week to -1 day',
                'fully_paid_at' => null,
                'cancellation_reason' => null,
                'count' => 2
            ],
            // Scenario 9: Cancelled by customer
            [
                'progress_status' => 'cancelled',
                'payment_status' => 'refunded',
                'started_at' => '-1 month to -2 weeks',
                'completed_at' => null,
                'fully_paid_at' => null,
                'cancellation_reason' => 'Customer changed their mind',
                'count' => 1
            ],
        ];

        $commissionId = 1;

        // Realistic commission descriptions
        $descriptions = [
            "I'd like a character portrait of my OC for my profile picture. She has long purple hair and wears a white dress with gold accents.",
            "Need artwork of my D&D character - a half-elf ranger with short brown hair, green eyes, and leather armor. He carries a longbow.",
            "Commission for my Twitch channel banner. My character is a cute cat girl with pink hair and twin tails, wearing a gaming headset.",
            "Looking for an illustration of my FFXIV character. She's a Miqo'te with red hair and tribal markings, wearing scholar robes.",
            "Portrait of my Genshin Impact OC. She's a Cryo user with ice-blue hair in a ponytail, wearing elegant traditional clothing.",
            "Need a character illustration for my visual novel project. The character is a schoolgirl with glasses and short black hair.",
            "Commission for my YouTube channel mascot. A cheerful boy character with messy blonde hair, blue eyes, and casual streetwear.",
            "Want an artwork of my furry OC - a wolf with silver fur, amber eyes, wearing a black leather jacket and jeans.",
            "Character art for my webcomic protagonist. She's a magical girl with long pink hair in braids, wielding a staff.",
            "Need a portrait of my Valorant-inspired OC. She has short white hair with purple highlights and tactical gear.",
            "Commission of my VTuber model concept. A demon girl with horns, red eyes, long black hair, and gothic lolita outfit.",
            "Character illustration for my light novel. He's a swordsman with spiky blue hair, determined expression, and fantasy armor.",
            "Portrait for my gaming clan logo. My character has dual-colored hair (black and red split), wearing cyberpunk outfit.",
            "Need artwork of my Honkai Star Rail OC. She's an elegant character with silver hair and star motifs on her outfit.",
            "Commission for anniversary gift - couple portrait of me and my partner as anime characters in formal attire.",
            "Character art of my Project Sekai OC. She's a musician with pastel rainbow hair, wearing stage outfit with music note accessories.",
            "Need a character sheet for my roleplay character - a vampire lord with long white hair, red eyes, and Victorian suit.",
            "Portrait of my Arknights operator OC. She has fox ears, orange hair, wearing tactical equipment with traditional elements.",
            "Commission for my story character - a knight with crimson armor, flowing cape, and determined eyes holding a great sword.",
            "Character illustration for my game development project. A mage with flowing blue robes and mystical staff."
        ];

        // Pricing table (solid round numbers in IDR)
        $priceTable = [
            // regular styles
            'headshot' => ['none' => 40000, 'simple' => 45000, 'detailed' => 50000],
            'bustup' => ['none' => 50000, 'simple' => 55000, 'detailed' => 60000],
            'halfbody' => ['none' => 65000, 'simple' => 75000, 'detailed' => 85000],
            'fullbody' => ['none' => 125000, 'simple' => 135000, 'detailed' => 175000],
            // cartoon styles
            'cartoon_bustup' => ['none' => 25000, 'simple' => 30000, 'detailed' => 35000],
            'cartoon_halfbody' => ['none' => 35000, 'simple' => 40000, 'detailed' => 45000],
            'cartoon_fullbody' => ['none' => 50000, 'simple' => 55000, 'detailed' => 65000],
        ];

        $descriptionIndex = 0;

        foreach ($scenarios as $scenario) {
            for ($i = 0; $i < $scenario['count']; $i++) {
                $createdAt = $faker->dateTimeBetween('-2 months', '-1 day');

                // Generate dates based on scenario
                $startedAt = null;
                $completedAt = null;
                $fullyPaidAt = null;
                $cancelledAt = null;
                $cancelledBy = null;

                if (!empty($scenario['started_at']) && is_string($scenario['started_at'])) {
                    list($start, $end) = explode(' to ', $scenario['started_at']);
                    $startedAt = $faker->dateTimeBetween($start, $end);
                }

                if (!empty($scenario['completed_at']) && is_string($scenario['completed_at'])) {
                    list($start, $end) = explode(' to ', $scenario['completed_at']);
                    $completedAt = $faker->dateTimeBetween($start, $end);
                }

                if (!empty($scenario['fully_paid_at']) && is_string($scenario['fully_paid_at'])) {
                    list($start, $end) = explode(' to ', $scenario['fully_paid_at']);
                    $fullyPaidAt = $faker->dateTimeBetween($start, $end);
                }

                // If cancelled scenario, set cancelled_by and cancelled_at
                if ($scenario['progress_status'] === 'cancelled' || $scenario['cancellation_reason']) {
                    $cancelledBy = $faker->randomElement(['artist', 'client', 'system']);
                    // cancelled_at between created_at and now
                    $cancelledAt = $faker->dateTimeBetween($createdAt, 'now');
                }

                // pick category & background_type first so price can be derived
                $category = $faker->randomElement($categories);
                $backgroundType = $faker->randomElement($backgroundTypes);

                // base price (personal use + background variant according to table)
                $basePrice = $priceTable[$category][$backgroundType] ?? 0;

                // decide commercial use (20% chance) and additional characters (0=65%,1=25%,2=10%)
                $isCommercial = (rand(1, 100) <= 20);
                $r = rand(1, 100);
                if ($r <= 65) {
                    $additionalChars = 0;
                } elseif ($r <= 90) {
                    $additionalChars = 1;
                } else {
                    $additionalChars = 2;
                }

                // apply multipliers
                $price = $basePrice;
                if ($isCommercial) {
                    $price *= 2.5; // +150% => 2.5x
                }
                if ($additionalChars > 0) {
                    $price *= (1 + 0.75 * $additionalChars); // +75% per additional character
                }

                // Round to nearest 1000 for solid numbers
                $price = round($price / 1000) * 1000;

                // Get description (cycle through array)
                $description = $descriptions[$descriptionIndex % count($descriptions)];
                $descriptionIndex++;

                // Reference images: only for commission_id 1 and 2
                $referenceImage = null;
                if ($commissionId === 1) {
                    $referenceImage = '/commission_images/1.png';
                } elseif ($commissionId === 2) {
                    $referenceImage = '/commission_images/2.png';
                } else if ($commissionId === 3) {
                    // network image
                    $referenceImage = 'https://media.istockphoto.com/id/814423752/photo/eye-of-model-with-colorful-art-make-up-close-up.jpg?s=612x612&w=0&k=20&c=l15OdMWjgCKycMMShP8UK94ELVlEGvt7GmB_esHWPYE=';
                } else if ($commissionId === 4) {
                    // network image
                    $referenceImage = 'https://static.vecteezy.com/vite/assets/photo-masthead-375-BoK_p8LG.webp';
                }

                DB::table('commissions')->insert([
                    'commission_id' => $commissionId,
                    'member_id' => $faker->randomElement($clientIds),
                    'category' => $category,
                    'background_type' => $backgroundType,
                    'is_commercial_use' => $isCommercial,
                    'additional_characters' => $additionalChars,
                    'description' => $description,
                    'reference_image' => $referenceImage,
                    'deadline' => $faker->dateTimeBetween('+1 week', '+3 months'),
                    'price' => $price,
                    'payment_status' => $scenario['payment_status'],
                    'progress_status' => $scenario['progress_status'],
                    // Cancellation fields
                    'cancellation_reason' => $scenario['cancellation_reason'],
                    'cancelled_by' => $cancelledBy,
                    'cancelled_at' => $cancelledAt,
                    // Lifecycle timestamps
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                    'fully_paid_at' => $fullyPaidAt,
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);

                $commissionId++;
            }
        }
    }
}
