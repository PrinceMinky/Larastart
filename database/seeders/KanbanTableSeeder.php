<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Comment;
use App\Models\KanbanCard;
use App\Models\KanbanBoard;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\KanbanColumn;
use Illuminate\Database\Seeder;
use App\Events\Kanban\CardCreated;
use App\Events\Kanban\BoardCreated;
use App\Events\Kanban\ColumnCreated;
use Illuminate\Support\Facades\Auth;
use App\Events\Comments\CommentCreated;

class KanbanTableSeeder extends Seeder
{
    public function run()
    {
        $this->seedBoard(
            'Default Board',
            [
                [
                    'title' => 'Backlog',
                    'slug' => 'backlog',
                    'cards' => [
                        [
                            'title' => 'User Reports Slow Load Times on Profile Page',
                            'description' => 'Users experience delays when loading their profile, especially during peak hours.',
                            'badges' => [['title' => 'Bug', 'color' => 'red']],
                            'due_at' => Carbon::now()->subDays(2), // past due
                        ],
                        [
                            'title' => 'Inconsistent Button Styles on Settings Page',
                            'description' => 'Fix button color and padding to match design system.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Investigate Unhandled Exception on Login',
                            'description' => 'Unhandled exceptions reported in logs after failed login attempts.',
                            'badges' => [['title' => 'Bug', 'color' => 'red'], ['title' => 'High priority', 'color' => 'yellow']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Database Migration for New Analytics Table',
                            'description' => 'Create new analytics table schema and migrate data accordingly.',
                            'badges' => [['title' => 'Backend', 'color' => 'green']],
                        ],
                        [
                            'title' => 'Correct Misalignment of Icons in Footer',
                            'description' => 'Icons appear misaligned on smaller screen sizes.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                    ],
                ],
                [
                    'title' => 'Planned',
                    'slug' => 'planned',
                    'cards' => [
                        [
                            'title' => 'Update Privacy Policy in App',
                            'description' => 'Include recent legal changes effective from next month.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Fix Issue with Search Bar Auto-Suggestions',
                            'description' => 'Auto-suggestions sometimes fail to load relevant results or show outdated data.',
                            'badges' => [['title' => 'Bug', 'color' => 'red'], ['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->subDay(), // past due
                        ],
                        [
                            'title' => 'Improve Loading Spinner Visuals',
                            'description' => 'Enhance the loading spinner animation for better user experience.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Fix Date Picker Not Accepting Keyboard Input',
                            'description' => 'Users unable to enter dates via keyboard; only mouse input works.',
                            'badges' => [['title' => 'Bug', 'color' => 'red']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Fix Permissions Issue in Admin Panel',
                            'description' => 'Certain users have inappropriate access rights to sensitive admin features.',
                            'badges' => [['title' => 'Backend', 'color' => 'green'], ['title' => 'Bug', 'color' => 'red']],
                        ],
                        [
                            'title' => 'Resolve Broken Image Links in Product Gallery',
                            'description' => 'Several product images fail to load due to incorrect URLs or missing files.',
                            'badges' => [['title' => 'Bug', 'color' => 'red']],
                            'due_at' => Carbon::now()->subDays(3), // past due
                        ],
                    ],
                ],
                [
                    'title' => 'In Progress',
                    'slug' => 'in-progress',
                    'cards' => [
                        [
                            'title' => 'Responsive Improvements on Mobile',
                            'description' => 'Enhance mobile layout for better usability and faster loading times.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Fix Issue with Sorting in Data Tables',
                            'description' => 'Sorting does not update the display correctly after filtering results.',
                            'badges' => [['title' => 'Bug', 'color' => 'red'], ['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Update API to Return Consistent Error Codes',
                            'description' => 'Ensure API responses use standardized error codes for all failure cases.',
                            'badges' => [['title' => 'Backend', 'color' => 'green']],
                        ],
                        [
                            'title' => 'Accessibility Audit',
                            'description' => 'Perform audit to improve accessibility compliance for users with disabilities.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'UI/UX Exploration for User Dashboard',
                            'description' => 'Research and prototype new UI/UX ideas to enhance dashboard usability.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->subHours(20), // past due recently
                        ],
                    ],
                ],
                [
                    'title' => 'In review',
                    'slug' => 'in-review',
                    'cards' => [
                        [
                            'title' => 'Resolve Issue with Double-Click on Buttons',
                            'description' => 'Buttons occasionally register double clicks, causing unintended actions.',
                            'badges' => [['title' => 'Bug', 'color' => 'red'], ['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Crash on Large File Upload',
                            'description' => 'Application crashes when users upload files larger than 100MB.',
                            'badges' => [['title' => 'High priority', 'color' => 'yellow']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Concurrent Request Handling in API',
                            'description' => 'Improve API to handle multiple simultaneous requests without failures.',
                            'badges' => [['title' => 'Backend', 'color' => 'green']],
                        ],
                    ],
                ],
            ]
        );

        $this->seedBoard(
            'Marketing Campaign',
            [
                [
                    'title' => 'Ideas',
                    'slug' => 'ideas',
                    'cards' => [
                        [
                            'title' => 'Launch Summer Social Media Campaign',
                            'description' => 'Plan and launch targeted ads across all major social platforms.',
                            'badges' => [['title' => 'High priority', 'color' => 'yellow']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Create New Email Newsletter Template',
                            'description' => 'Design a fresh, engaging template for upcoming newsletters.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Research Influencer Collaborations',
                            'description' => 'Identify potential influencers and assess collaboration opportunities.',
                            'badges' => [['title' => 'Backend', 'color' => 'green']],
                        ],
                    ],
                ],
                [
                    'title' => 'Planning',
                    'slug' => 'planning',
                    'cards' => [
                        [
                            'title' => 'Schedule Influencer Collaborations',
                            'description' => 'Reach out to potential influencers and set up contracts.',
                            'badges' => [['title' => 'Backend', 'color' => 'green']],
                            'due_at' => Carbon::now()->subDays(1), // past due
                        ],
                        [
                            'title' => 'Design Landing Page for Campaign',
                            'description' => 'Create engaging and responsive landing page for campaign visitors.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                    ],
                ],
                [
                    'title' => 'Execution',
                    'slug' => 'execution',
                    'cards' => [
                        [
                            'title' => 'Deploy Ads on Facebook and Instagram',
                            'description' => 'Launch and monitor paid ads across Facebook and Instagram platforms.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                        [
                            'title' => 'Email Newsletter Launch',
                            'description' => 'Send out the first newsletter using the new template.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                    ],
                ],
                [
                    'title' => 'Analysis',
                    'slug' => 'analysis',
                    'cards' => [
                        [
                            'title' => 'Analyze Social Media Engagement',
                            'description' => 'Review engagement metrics from recent social campaigns.',
                            'badges' => [['title' => 'Backend', 'color' => 'green']],
                        ],
                        [
                            'title' => 'Collect Feedback from Email Campaign',
                            'description' => 'Gather user responses and feedback post-email campaign.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->subDays(2), // past due
                        ],
                    ],
                ],
            ]
        );

        $this->seedBoard(
            'Customer Support',
            [
                [
                    'title' => 'New Tickets',
                    'slug' => 'new-tickets',
                    'cards' => [
                        [
                            'title' => 'Resolve Broken Image Links in Product Gallery',
                            'description' => 'Fix all broken links causing images to not display in product gallery.',
                            'badges' => [['title' => 'Bug', 'color' => 'red']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Fix Date Picker Not Accepting Keyboard Input',
                            'description' => 'Allow users to enter dates via keyboard in the date picker component.',
                            'badges' => [['title' => 'Bug', 'color' => 'red']],
                        ],
                        [
                            'title' => 'Customer Reports Login Issues',
                            'description' => 'Investigate and resolve reported login failures from multiple customers.',
                            'badges' => [['title' => 'High priority', 'color' => 'yellow']],
                            'due_at' => Carbon::now()->subDays(1), // past due
                        ],
                    ],
                ],
                [
                    'title' => 'In Review',
                    'slug' => 'in-review',
                    'cards' => [
                        [
                            'title' => 'Crash on Large File Upload',
                            'description' => 'Application crashes when users upload files larger than 100MB.',
                            'badges' => [['title' => 'High priority', 'color' => 'yellow']],
                            'due_at' => Carbon::now()->addDay(), // due tomorrow
                        ],
                        [
                            'title' => 'Validate Customer Feedback Form',
                            'description' => 'Ensure validation rules are correctly enforced on feedback form inputs.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                        ],
                    ],
                ],
                [
                    'title' => 'Resolved',
                    'slug' => 'resolved',
                    'cards' => [
                        [
                            'title' => 'Fix Permissions Issue in Admin Panel',
                            'description' => 'Corrected user roles and permissions to prevent unauthorized access.',
                            'badges' => [['title' => 'Backend', 'color' => 'green'], ['title' => 'Bug', 'color' => 'red']],
                        ],
                        [
                            'title' => 'Update Help Center FAQ',
                            'description' => 'Added new frequently asked questions and updated existing answers.',
                            'badges' => [['title' => 'UI', 'color' => 'blue']],
                            'due_at' => Carbon::now()->subDays(4), // past due
                        ],
                    ],
                ],
            ]
        );
    }

    private function seedBoard(string $boardTitle, array $columns)
    {
        $allBadges = [];

        $board = KanbanBoard::create([
            'title' => $boardTitle,
            'slug' => Str::slug($boardTitle),
            'owner_id' => 1,
        ]);

        Auth::loginUsingId(1);
        event(new BoardCreated($board));

        // Get all admin user IDs except the owner
        $adminUserIds = User::role('Admin')
            ->where('id', '!=', $board->owner_id)
            ->pluck('id')
            ->toArray();

        if (!empty($adminUserIds)) {
            $randomCount = rand(1, count($adminUserIds));
            $randomAdminUserIds = Arr::random($adminUserIds, $randomCount);
        } else {
            $randomAdminUserIds = [];
        }

        // Attach randomly picked admins to the board
        $board->users()->sync($randomAdminUserIds);

        // Fetch the attached users for this board for assignment later
        $boardUserIds = $board->users()->pluck('users.id')->toArray();

        foreach ($columns as $colIndex => $columnData) {
            $column = KanbanColumn::create([
                'title' => $columnData['title'],
                'slug' => Str::slug($columnData['title']), 
                'position' => $colIndex,
                'board_id' => $board->id,
            ]);

            event(new ColumnCreated($column));

            foreach ($columnData['cards'] as $cardIndex => $cardData) {
                foreach ($cardData['badges'] as $badge) {
                    $badgeKey = $badge['title'] . '-' . $badge['color'];
                    $allBadges[$badgeKey] = $badge;
                }

                $card = KanbanCard::create([
                    'column_id' => $column->id,
                    'title' => $cardData['title'],
                    'description' => $cardData['description'] ?? null,
                    'badges' => $cardData['badges'],
                    'position' => $cardIndex,
                    'due_at' => $cardData['due_at'] ?? null,
                    'assigned_user_id' => (rand(0, 1) === 1 && !empty($boardUserIds)) ? Arr::random($boardUserIds) : null,
                ]);

                event(new CardCreated($card));

                // Add random comments
                $numComments = rand(1, 5);
                for ($i = 0; $i < $numComments; $i++) {
                    $commentUserId = Arr::random($boardUserIds);
                    Auth::loginUsingId($commentUserId);

                    $comment = $card->comments()->create([
                        'user_id' => $commentUserId,
                        'body' => fake()->sentence(rand(6, 12)),
                    ]);

                    event(new CommentCreated($comment));

                    // Randomly like this comment by some users
                    $numLikes = rand(0, count($boardUserIds));
                    if ($numLikes > 0) {
                        $likingUserIds = Arr::random($boardUserIds, $numLikes);
                        $comment->likedByUsers()->attach($likingUserIds);
                    }

                    // Randomly add 0-3 child comments to this comment
                    $numChildComments = rand(0, 3);
                    for ($j = 0; $j < $numChildComments; $j++) {
                        $childCommentUserId = Arr::random($boardUserIds);
                        $childComment = Comment::create([
                            'user_id' => $childCommentUserId,
                            'body' => fake()->sentence(rand(4, 10)),
                            'parent_id' => $comment->id,
                            'model_class' => get_class($card),
                            'model_id' => $card->id,
                        ]);

                        // Randomly like this child comment by some users
                        $numChildLikes = rand(0, count($boardUserIds));
                        if ($numChildLikes > 0) {
                            $likingChildUserIds = Arr::random($boardUserIds, $numChildLikes);
                            $childComment->likedByUsers()->attach($likingChildUserIds);
                        }
                    }
                }
            }
        }

        $board->update([
            'badges' => array_values($allBadges),
        ]);
    }
}
