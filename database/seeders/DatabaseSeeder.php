<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CompanyTypeSeeder::class,
            IndustrySeeder::class,
            DocumentTypeSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            // ModuleSeeder::class,
            // PermissionSeeder::class,
            // RoleSeeder::class,
            // RoleHasPermissionSeeder::class,
            RolePermissionMasterSeeder::class,
            UserSeeder::class,
            SocialStratumSeeder::class,
            SexTypeSeeder::class,
            RhTypeSeeder::class,
            ScholarshipSeeder::class,
            AcademicAchievementTypeSeeder::class,
            CivilStatusSeeder::class,
            HousingTenureSeeder::class,
            RelationshipSeeder::class,
            OccupationSeeder::class,
            BankTypeSeeder::class,
            EpsTypeSeeder::class,
            AfpTypeSeeder::class,
            ArlTypeSeeder::class,
            CcfTypeSeeder::class,
            PositionCriticalityLevelSeeder::class,
            PositionRiskClassSeeder::class,
            ContractTypeSeeder::class,
            MedicalExaminationTypeSeeder::class,
            HomeVisitTypeSeeder::class,
            ContractualDocumentTypeSeeder::class,
            AbsenceTypeSeeder::class,
            AbsenceSubtypeSeeder::class,
            DiseaseClassificationSeeder::class,
            AbsenceStatusTypesSeeder::class,
            VacancyReasonSeeder::class,
            VacancyStatusSeeder::class,
            SelectionSourceSeeder::class,
            CollaboratorRequisitionTypeSeeder::class,
            CollaboratorSeeder::class,
            CampusSeeder::class,
            AreaSeeder::class,
            PositionSeeder::class,
        ]);
    }
}
