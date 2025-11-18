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
        // Sample reference images (external placeholders or your local assets)
        $sampleImages = [
            'https://picsum.photos/seed/comm1/800/600',
            'https://picsum.photos/seed/comm2/800/600',
            'https://picsum.photos/seed/comm3/800/600',
            'https://picsum.photos/seed/comm4/800/600',
            'https://picsum.photos/seed/comm5/800/600',
            '/assets/comm_sample/sample1.jpg',
            '/assets/comm_sample/sample2.jpg',
        ];
        
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

                // Pricing table (values in IDR)
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

                // ensure 2 decimal places (store as decimal)
                $price = round($price, 2);
 
                DB::table('commissions')->insert([
                    'commission_id' => $commissionId,
                    'member_id' => $faker->randomElement($clientIds),
                    'category' => $category,
                    'background_type' => $backgroundType,
                    'is_commercial_use' => $isCommercial,
                    'additional_characters' => $additionalChars,
                    'description' => $faker->paragraph,
                    // 70% chance to include a reference image
                    'reference_image' => (rand(0, 9) < 7) ? $faker->randomElement($sampleImages) : null,
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
