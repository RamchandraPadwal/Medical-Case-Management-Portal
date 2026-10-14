# Traceability Matrix

| ID | Requirement (input) | Implementation (output) | Verification |
|----|---------------------|-------------------------|--------------|
| REQ-001 | Valid user authentication succeeds | Breeze `AuthenticatedSessionController@store` | Feature test: `test_valid_login_succeeds` |
| REQ-002 | Invalid credentials rejected with error | Breeze `AuthenticatedSessionController@store` + session errors | Feature test: `test_invalid_login_is_rejected` |
| REQ-003 | Guests blocked from case pages and API | `auth` middleware (web) & `auth:sanctum` / `EnsureApiAuthenticated` (API) | Feature test: `test_guest_cannot_open_case_pages_or_api` |
| REQ-004 | Admin shall be able to create a case (Web) | `MedicalCaseController@store` + `cases/_form.blade.php`; `MedicalCasePolicy@create` | Feature test: `test_admin_can_create_a_case` |
| REQ-005 | Admin shall be able to create a case (API) | `Api\MedicalCaseController@store`; `MedicalCaseRequest@authorize` | Feature test: `test_admin_can_create_a_case_through_the_api` |
| REQ-006 | Case Number shall be unique | Unique DB index (`cases_table` migration) + `Rule::unique` in `MedicalCaseRequest` | Feature test: `test_duplicate_case_number_fails_with_422` |
| REQ-007 | Editing a case can keep its own case number | `Rule::unique()->ignore($id)` in `MedicalCaseRequest` | Feature test: `test_editing_a_case_can_keep_its_own_case_number` |
| REQ-008 | Viewer forbidden from deleting cases | `MedicalCasePolicy@delete` + `Gate::authorize` / `Gate::denies` (403) | Feature test: `test_viewer_cannot_delete_a_case` |
| REQ-009 | Admin shall be able to delete a case | `MedicalCaseController@destroy` + `MedicalCasePolicy@delete` | Feature test: `test_admin_can_delete_a_case` |
| REQ-010 | Missing case returns 404 on API | `Api\MedicalCaseController@show` / `find` | Feature test: `test_api_returns_404_for_missing_case` |
