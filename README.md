# CI4 Student Profile Activity

## Database
- **Name:** `ci4_crud_exam`

## Key Features
- User authentication (login/register)
- Student profile page with photo upload
- Records CRUD operations
- Session-based security

## Setup
1. Import `ci4_crud_exam.sql` to MySQL
2. Run `composer install`
3. Create `public/uploads/profiles/` folder
4. Start with `php spark serve`
5. Visit `http://localhost:8080`

## Login Credentials
| Account | Email | Password |
|---------|-------|----------|
| Test User | `adiacsfern@gmail.com` | admin123 |

## Profile Routes
| Route | Method | Description |
|-------|--------|-------------|
| `/profile` | GET | View profile |
| `/profile/edit` | GET | Edit form |
| `/profile/update` | POST | Save changes |