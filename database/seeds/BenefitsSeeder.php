<?php

use Illuminate\Database\Seeder;

class BenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $benefits = [
            ['id' => 1, 'policy_benefit' => 'In-patient Hospitalization', 'benefit_explanation' => 'Private room', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 2, 'policy_benefit' => 'Pre – Hospitalization', 'benefit_explanation' => '60 days', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 3, 'policy_benefit' => 'Post – Hospitalization', 'benefit_explanation' => '90 days', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 4, 'policy_benefit' => 'Day Care Treatment', 'benefit_explanation' => 'Upto full Sum Insured', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 5, 'policy_benefit' => 'Domiciliary Treatment', 'benefit_explanation' => 'Upto full Sum Insured', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 6, 'policy_benefit' => 'Ambulance Cover', 'benefit_explanation' => 'Upto Rs. 2000 per incident', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 7, 'policy_benefit' => 'Donor Expenses', 'benefit_explanation' => 'Upto full Sum Insured', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 8, 'policy_benefit' => 'Worldwide Emergency Cover', 'benefit_explanation' => 'Upto full Sum Insured once in a policy year', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 9, 'policy_benefit' => 'Health Maintenance Benefit', 'benefit_explanation' => 'Upto Rs. 500', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 10, 'policy_benefit' => 'Health Check-Up', 'benefit_explanation' => 'Available once every 3rd Policy year', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 11, 'policy_benefit' => 'Expert Opinion on Critical illness', 'benefit_explanation' => 'Available once during the Policy Year', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 9999, 'policy_benefit' => 'Others (specify)', 'benefit_explanation' => 'Specify', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],            
        ];
        if(DB::table('benefits')->get()->count() == 0) {
            DB::table('benefits')->insert($benefits);
        } else {
            echo "benefits table is not empty.";
        }
    }
}
