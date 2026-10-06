# Student Task Manager

## Requirements
- PHP
- MySQL or MariaDB
- A local PHP server such as Laragon, XAMPP, MAMP, or PHP's built-in server

## Setup

1. Create/import the database using `database.sql`.
2. Open `db.php`.
3. Change the database username/password if your MySQL setup is different.
4. Put the project folder inside your local server's web directory.
5. Open `index.php` through your local server.

## Files

- `index.php` - displays tasks and the incomplete-task filter
- `create.php` - creates a task
- `edit.php` - updates a task
- `delete.php` - deletes a task
- `db.php` - PDO database connection
- `functions.php` - reusable session flash-message functions
- `style.css` - basic styling
- `database.sql` - database/table creation

## Assigned Challenge Used in This Practice Version

Filtering incomplete tasks.

The filter is available from:
`index.php?filter=incomplete`

If the instructor gives a different challenge, this part should be changed to match the assigned challenge.

## AI-Use Reflection Template

Student Name:

Student ID:

AI tool(s) used:

Three examples of how AI helped me:
1.
2.
3.

One AI-generated suggestion or piece of code that I changed or rejected:

What was it?

Why did I change/reject it?

The part of this application I understand least:

## Important

This project is intentionally written with simple PHP so that the student can understand and explain the code during the Code Defense and make changes during the Live Code Modification.
