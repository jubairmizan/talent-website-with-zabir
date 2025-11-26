<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MemberProfile;
use App\Models\User;

class MemberProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some member users if they don't exist
        $this->createMemberUsersIfNeeded();

        $memberUsers = User::where('role', 'member')->get();

        if ($memberUsers->isEmpty()) {
            $this->command->warn('No member users found. Creating sample member users.');
            return;
        }

        $memberProfiles = [
            [
                'first_name' => 'Jennifer',
                'last_name' => 'Smith',
                'bio' => 'Marketing professional with a passion for creative design and brand storytelling. I love working with talented creators to bring innovative ideas to life.',
                'location' => 'New York, NY',
                'interests' => 'Graphic Design, Digital Marketing, Brand Strategy, Photography, Content Creation',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Johnson',
                'bio' => 'Small business owner looking for creative solutions to grow my company. Always interested in fresh perspectives and innovative approaches.',
                'location' => 'Los Angeles, CA',
                'interests' => 'Web Development, E-commerce, Business Growth, Technology, Innovation',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'bio' => 'Event planner and entrepreneur who appreciates beautiful design and creative storytelling. I believe great visuals make all the difference.',
                'location' => 'Miami, FL',
                'interests' => 'Event Planning, Photography, Videography, Social Media, Creative Arts',
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Chen',
                'bio' => 'Tech startup founder passionate about user experience and innovative design. Always looking for creative talent to collaborate with.',
                'location' => 'San Francisco, CA',
                'interests' => 'UI/UX Design, Technology, Startups, Innovation, Product Development',
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Thompson',
                'bio' => 'Nonprofit director dedicated to making a positive impact. I value creativity and authentic storytelling in our mission-driven work.',
                'location' => 'Chicago, IL',
                'interests' => 'Nonprofit Work, Social Impact, Content Writing, Community Building, Advocacy',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'bio' => 'Freelance consultant who appreciates quality creative work. I enjoy connecting with talented professionals and exploring new ideas.',
                'location' => 'Austin, TX',
                'interests' => 'Consulting, Business Strategy, Creative Arts, Networking, Professional Development',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'bio' => 'Marketing agency owner with an eye for exceptional creative talent. I love discovering new artists and building long-term partnerships.',
                'location' => 'Seattle, WA',
                'interests' => 'Marketing, Creative Direction, Team Building, Talent Acquisition, Brand Development',
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Miller',
                'bio' => 'Restaurant owner who believes in the power of great design and branding. Looking for creative partners to help tell our story.',
                'location' => 'Portland, OR',
                'interests' => 'Food & Beverage, Restaurant Management, Branding, Local Business, Community',
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'bio' => 'Fashion enthusiast and blogger who loves collaborating with creative professionals. Always seeking fresh perspectives and innovative ideas.',
                'location' => 'Boston, MA',
                'interests' => 'Fashion, Blogging, Photography, Social Media, Creative Collaboration',
            ],
            [
                'first_name' => 'Christopher',
                'last_name' => 'Anderson',
                'bio' => 'Real estate developer with an appreciation for good design and architecture. I value creativity in all aspects of business.',
                'location' => 'Denver, CO',
                'interests' => 'Real Estate, Architecture, Design, Business Development, Investment',
            ],
        ];

        foreach ($memberProfiles as $index => $profile) {
            if (isset($memberUsers[$index])) {
                MemberProfile::create(array_merge($profile, [
                    'user_id' => $memberUsers[$index]->id,
                ]));
            }
        }

        $this->command->info('Member profiles seeded successfully!');
    }

    private function createMemberUsersIfNeeded(): void
    {
        $memberUsers = [
            [
                'name' => 'Jennifer Smith',
                'email' => 'jennifer.smith@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'David Johnson',
                'email' => 'david.johnson@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Robert Chen',
                'email' => 'robert.chen@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.thompson@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'James Miller',
                'email' => 'james.miller@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
            [
                'name' => 'Christopher Anderson',
                'email' => 'christopher.anderson@member.com',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ],
        ];

        foreach ($memberUsers as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }
    }
}