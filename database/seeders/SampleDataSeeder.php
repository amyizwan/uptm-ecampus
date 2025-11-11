<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Document;
use App\Models\Announcement;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Get or create a student
        $student = User::where('email', 'student@uptm.edu.my')->first();
        if (!$student) {
            $student = User::create([
                'name' => 'Ali Student',
                'email' => 'student@uptm.edu.my',
                'password' => bcrypt('password'),
                'role' => 'student',
                'student_id' => 'S12345'
            ]);
        }

        // Get or create a lecturer
        $lecturer = User::where('email', 'lecturer@uptm.edu.my')->first();
        if (!$lecturer) {
            $lecturer = User::create([
                'name' => 'Dr. Ahmad Lecturer',
                'email' => 'lecturer@uptm.edu.my',
                'password' => bcrypt('password'),
                'role' => 'lecturer'
            ]);
        }

        // Get or create admin
        $admin = User::where('email', 'admin@uptm.edu.my')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'System Admin',
                'email' => 'admin@uptm.edu.my',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }

        // Create subjects
        $subjects = [
            ['name' => 'Web Development', 'code' => 'WEB101', 'lecturer_id' => $lecturer->id],
            ['name' => 'Database Systems', 'code' => 'DBMS202', 'lecturer_id' => $lecturer->id],
            ['name' => 'Cyber Security', 'code' => 'CYBER301', 'lecturer_id' => $lecturer->id],
        ];

        foreach ($subjects as $subjectData) {
            Subject::firstOrCreate(
                ['code' => $subjectData['code']],
                $subjectData
            );
        }

        $webDev = Subject::where('code', 'WEB101')->first();
        $database = Subject::where('code', 'DBMS202')->first();
        $cyber = Subject::where('code', 'CYBER301')->first();

        // Create sample grades
        $grades = [
            ['student_id' => $student->id, 'subject_id' => $webDev->id, 'assignment_name' => 'HTML/CSS Project', 'marks' => 85, 'max_marks' => 100, 'grade' => 'A'],
            ['student_id' => $student->id, 'subject_id' => $database->id, 'assignment_name' => 'SQL Quiz', 'marks' => 72, 'max_marks' => 100, 'grade' => 'B'],
            ['student_id' => $student->id, 'subject_id' => $cyber->id, 'assignment_name' => 'Security Report', 'marks' => 90, 'max_marks' => 100, 'grade' => 'A'],
            ['student_id' => $student->id, 'subject_id' => $webDev->id, 'assignment_name' => 'JavaScript Assignment', 'marks' => 68, 'max_marks' => 100, 'grade' => 'C'],
        ];

        foreach ($grades as $gradeData) {
            Grade::firstOrCreate(
                [
                    'student_id' => $gradeData['student_id'],
                    'subject_id' => $gradeData['subject_id'],
                    'assignment_name' => $gradeData['assignment_name']
                ],
                $gradeData
            );
        }

        // Create sample attendance
        $attendance = [
            ['student_id' => $student->id, 'subject_id' => $webDev->id, 'date' => Carbon::now()->subDays(5), 'status' => 'present'],
            ['student_id' => $student->id, 'subject_id' => $database->id, 'date' => Carbon::now()->subDays(4), 'status' => 'present'],
            ['student_id' => $student->id, 'subject_id' => $cyber->id, 'date' => Carbon::now()->subDays(3), 'status' => 'late'],
            ['student_id' => $student->id, 'subject_id' => $webDev->id, 'date' => Carbon::now()->subDays(2), 'status' => 'absent'],
            ['student_id' => $student->id, 'subject_id' => $database->id, 'date' => Carbon::now()->subDays(1), 'status' => 'present'],
        ];

        foreach ($attendance as $attendanceData) {
            Attendance::firstOrCreate(
                [
                    'student_id' => $attendanceData['student_id'],
                    'subject_id' => $attendanceData['subject_id'],
                    'date' => $attendanceData['date']
                ],
                $attendanceData
            );
        }

        // Create sample documents
        $documents = [
            ['title' => 'Web Development Syllabus', 'type' => 'syllabus', 'file_path' => '/documents/syllabus.pdf', 'subject_id' => $webDev->id],
            ['title' => 'Database Notes Chapter 1', 'type' => 'notes', 'file_path' => '/documents/db_notes.pdf', 'subject_id' => $database->id],
            ['title' => 'Cyber Security Lab Manual', 'type' => 'lab_manual', 'file_path' => '/documents/lab_manual.pdf', 'subject_id' => $cyber->id],
            ['title' => 'Academic Calendar 2024', 'type' => 'resources', 'file_path' => '/documents/calendar.pdf', 'subject_id' => $webDev->id],
        ];

        foreach ($documents as $docData) {
            Document::firstOrCreate(
                ['title' => $docData['title']],
                $docData
            );
        }

        // Create sample announcements
        $announcements = [
            ['title' => 'Welcome to Semester 1 2024', 'content' => 'Welcome all students to the new semester! Please check your schedules and course materials.', 'user_id' => $admin->id, 'subject_id' => null],
            ['title' => 'Web Development Class Cancelled', 'content' => 'Web Development class on Friday is cancelled due to public holiday. Next class will be on Monday.', 'user_id' => $lecturer->id, 'subject_id' => $webDev->id],
            ['title' => 'Database Assignment Deadline', 'content' => 'Reminder: Database assignment submission deadline is this Friday 5:00 PM.', 'user_id' => $lecturer->id, 'subject_id' => $database->id],
            ['title' => 'Cyber Security Lab Session', 'content' => 'There will be a special lab session for Cyber Security this Wednesday at Lab 3.', 'user_id' => $lecturer->id, 'subject_id' => $cyber->id],
        ];

        foreach ($announcements as $announcementData) {
            Announcement::firstOrCreate(
                ['title' => $announcementData['title']],
                $announcementData
            );
        }

        $this->command->info('🎉 Sample data created successfully!');
        $this->command->info('👨‍🎓 Student Login: student@uptm.edu.my / password');
        $this->command->info('👨‍🏫 Lecturer Login: lecturer@uptm.edu.my / password');
        $this->command->info('👨‍💼 Admin Login: admin@uptm.edu.my / password');
    }
}