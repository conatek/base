# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

MuyHumano is an HR management system (Sistema de Gestión de Talento Humano) built with Laravel 12 and Vue 3. It manages collaborators (employees), companies, contracts, absences, and various HR-related modules.

## Development Commands

```bash
# Install dependencies
composer install
npm install

# Run development server (Vite)
npm run dev

# Build for production
npm run build

# Run PHP tests
php artisan test
./vendor/bin/phpunit

# Run single test file
./vendor/bin/phpunit tests/Feature/ExampleTest.php

# Run specific test method
./vendor/bin/phpunit --filter test_method_name

# Code linting (Laravel Pint)
./vendor/bin/pint

# Laravel artisan commands
php artisan migrate
php artisan queue:work
php artisan cache:clear
```

## Architecture

### Multi-tenant Structure
- Companies are the top-level entity; Users and Collaborators belong to a Company
- Roles and Permissions (via Spatie) are scoped to companies
- User roles hierarchy: Master > Super > Admin > Default

### Core Domain Models
- **Company**: Organization entity with users, roles, and permissions
- **User**: Authentication entity with Spatie roles/permissions (`HasRoles` trait)
- **Collaborator**: Employee record with extensive HR data (personal info, contracts, social security, bank accounts, family, academic achievements, medical exams, home visits)
- **CollaboratorContract**: Employment contracts with positions, areas, campuses, and contract types
- **Position**: Job positions within areas and campuses

### Key Relationships
```
Company
  └── User (can have Collaborator)
  └── Collaborator
        └── CollaboratorContract (multiple)
        └── CollaboratorSocialSecurity
        └── CollaboratorBankAccount
        └── CollaboratorFamily (multiple)
        └── CollaboratorAcademicAchievement (multiple)
        └── CollaboratorMedicalExamination (multiple)
        └── CollaboratorHomeVisit (multiple)
```

### Frontend Architecture
- Vue 3 with async components registered in `resources/js/components.js`
- Components organized by domain: `collaborators/`, `company/`, `users/`, `modules/`, `tools/`
- Permission checking via `$can()` global method (reads from `window.Laravel.permissions`)
- Uses VueSweetalert2, vue-good-table-next, FontAwesome icons
- Vite configuration in `vite.config.js` with `@` alias for `resources/js`

### Backend Patterns
- **Fortify Actions**: User creation/update logic in `app/Actions/Fortify/`
- **Observers**: `CompanyObserver` for company-related side effects
- **Jobs**: PDF report generation (uses Browsershot/Puppeteer)
- **Imports/Exports**: Excel import/export for collaborators via Maatwebsite/Excel
- **Helper functions**: Global helpers in `app/helpers.php` (auto-loaded via composer)

### External Services
- **Cloudinary**: Image storage for profile photos (`image_url`, `image_public_id` fields)
- **Browsershot/Puppeteer**: PDF generation for reports
- **Maatwebsite/Excel**: Spreadsheet import/export

### HR Modules (routes under `/modules/`)
- Selection (recruitment/hiring)
- Absence (leave management)
- Training
- Performance
- Provision (equipment/supplies)
- Wellness

### Route Organization
All authenticated routes in `routes/web.php` under `auth` middleware group. Key patterns:
- REST-style routes for CRUD operations
- Data endpoints return JSON: `/collaborators-data/{company_id}`, `/contracts-data/{company_id}`
- File downloads: `/download-*` routes for certificates and documents

## Language

The codebase and UI are in Spanish. Model names and comments use Spanish terminology (e.g., "colaborador" for employee, "empresa" for company).
