<?php

namespace Database\Seeders;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed demo accounts and demo school data.
     * Passwords are "password" for every demo account. Local demo use only.
     * Safe to run again: existing demo rows are reused, not duplicated.
     */
    public function run(): void
    {
        $this->demoUser('admin@example.com', 'Demo Admin', 'admin');
        $this->demoUser('principal@example.com', 'Demo Principal', 'principal');
        $teacher = $this->demoUser('teacher@example.com', 'Demo Teacher', 'teacher');
        $demoStudentUser = $this->demoUser('student@example.com', 'Demo Student', 'student');

        $math = $this->demoSubject('MATH-101', 'Mathematics', $teacher);
        $science = $this->demoSubject('SCI-101', 'Science', $teacher);

        // The demo student login gets a student record too, so it can be used for "My marks" later.
        $demoStudent = Student::firstOrCreate(
            ['user_id' => $demoStudentUser->id],
            ['student_no' => Student::nextStudentNumber()],
        );
        $math->students()->syncWithoutDetaching([$demoStudent->id]);

        // Extra students so the teacher pages have real rows to show.
        $classmates = [
            ['Ana Reyes', 'ana.reyes@example.com', 92, 85],
            ['Ben Santos', 'ben.santos@example.com', 78, 81],
            ['Carla Cruz', 'carla.cruz@example.com', 65, 70],
        ];

        foreach ($classmates as [$name, $email, $mathMark, $scienceMark]) {
            $student = $this->demoStudent($name, $email);
            $math->students()->syncWithoutDetaching([$student->id]);
            $science->students()->syncWithoutDetaching([$student->id]);

            Mark::updateOrCreate(
                ['student_id' => $student->id, 'subject_id' => $math->id, 'quarter' => 1],
                ['mark' => $mathMark],
            );
            Mark::updateOrCreate(
                ['student_id' => $student->id, 'subject_id' => $science->id, 'quarter' => 1],
                ['mark' => $scienceMark],
            );
        }
    }

    /**
     * Find a demo user by email, or create it with the given role.
     * Role is set through the factory, never through mass assignment.
     */
    private function demoUser(string $email, string $name, string $role): User
    {
        $existing = User::where('email', $email)->first();

        if ($existing) {
            return $existing;
        }

        $factory = match ($role) {
            'teacher' => User::factory()->teacher(),
            'student' => User::factory()->student(),
            'admin' => User::factory()->admin(),
            default => User::factory()->principal(),
        };

        return $factory->create(['name' => $name, 'email' => $email]);
    }

    /**
     * A student with a login account and a student record.
     */
    private function demoStudent(string $name, string $email): Student
    {
        $user = $this->demoUser($email, $name, 'student');

        return Student::firstOrCreate(
            ['user_id' => $user->id],
            ['student_no' => Student::nextStudentNumber()],
        );
    }

    /**
     * A subject taught by the demo teacher.
     */
    private function demoSubject(string $code, string $name, User $teacher): Subject
    {
        return Subject::firstOrCreate(
            ['code' => $code],
            ['name' => $name, 'teacher_id' => $teacher->id],
        );
    }
}
