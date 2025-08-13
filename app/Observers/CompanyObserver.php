<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\StaffProvider;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        // Crear registro inicial en staff_providers
        if (!StaffProvider::where('company_id', $company->id)->exists()) {
            StaffProvider::create([
                'company_id' => $company->id,
                'provider_type_id' => 1,
                'name' => $company->company_name,
            ]);
        }
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        //
    }
}
