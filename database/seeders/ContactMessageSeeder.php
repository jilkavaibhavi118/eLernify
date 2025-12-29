<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMessage;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'subject' => 'Course Inquiry',
                'message' => 'I would like to know more about the Web Development course.',
                'status' => 'pending',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'subject' => 'Payment Issue',
                'message' => 'My payment was deducted but the course is not unlocked.',
                'status' => 'pending',
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert@example.com',
                'subject' => 'Feedback',
                'message' => 'The platform is amazing! Keep up the good work.',
                'status' => 'replied',
                'reply' => 'Thank you for your kind words!',
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::create($message);
        }
    }
}
