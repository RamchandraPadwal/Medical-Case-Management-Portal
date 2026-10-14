# Database design

MySQL, created with Laravel migrations.

## users

| Column | Type | Notes |
|--------|------|-------|
| id | bigint, PK | |
| name | varchar | |
| email | varchar, unique | |
| password | varchar | hashed |
| role | varchar(20) | `admin` or `viewer`, default `viewer` (added by `add_role_to_users_table`) |
| created_at / updated_at | timestamps | |

(Breeze also adds `email_verified_at`, `remember_token`; Sanctum adds `personal_access_tokens`.)

## cases

| Column | Type | Notes |
|--------|------|-------|
| id | bigint, PK | auto-generated |
| case_number | varchar(50) | **unique index**, e.g. CASE-0001 |
| patient_reference | varchar(100) | dummy code |
| surgeon_name | varchar(100) | |
| implant_type | varchar(100) | |
| status | varchar(20) | **indexed**; Draft, Planning, In Review, Approved, Completed, Cancelled |
| priority | varchar(10) | Low, Medium, High |
| surgery_date | date, nullable | |
| created_by | bigint, FK -> users.id | set from the logged-in user |
| created_at / updated_at | timestamps | |

## Relationship

```
users 1 ───────< cases
        (cases.created_by -> users.id)
```

One user creates many cases; each case has exactly one creator. The foreign key stops a user from being deleted while they still own cases.

Status and priority are stored as strings and validated against fixed lists in the `MedicalCase` model (`STATUSES`, `PRIORITIES`).
