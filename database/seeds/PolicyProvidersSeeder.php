<?php

use Illuminate\Database\Seeder;

class PolicyProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $providers = [
            ['id' => 1, 'policy_provider' => 'Apollo Munich Health Insurance Company Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 2, 'policy_provider' => 'Bajaj Allianz General Insurance Co Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 3, 'policy_provider' => 'Bharti AXA General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 4, 'policy_provider' => 'Cholamandalam MS General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 5, 'policy_provider' => 'Cigna TTK.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 6, 'policy_provider' => 'Future Generali India Insurance Company Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 7, 'policy_provider' => 'HDFC ERGO General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 8, 'policy_provider' => 'Iffco Tokio General Insurance Co Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 9, 'policy_provider' => 'L&T General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 10, 'policy_provider' => 'MAX Bupa Health Insurance Company Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 11, 'policy_provider' => 'National Insurance Co Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 12, 'policy_provider' => 'New India Assurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 13, 'policy_provider' => 'Oriental Insurance Co. Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 14, 'policy_provider' => 'Raheja QBE General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 15, 'policy_provider' => 'Reliance General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 16, 'policy_provider' => 'Religare Health Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 17, 'policy_provider' => 'Royal Sundaram Alliance Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 18, 'policy_provider' => 'SBI General Insurance Company Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 19, 'policy_provider' => 'Shriram General Insurance Company', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 20, 'policy_provider' => 'Star Health and Allied insurance Co Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 21, 'policy_provider' => 'Tata AIG General Insurance Co. Ltd.', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 22, 'policy_provider' => 'United India Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 23, 'policy_provider' => 'Universal Sompo General Insurance Co Ltd', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['id' => 9999, 'policy_provider' => 'Others', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
        ];
        if(DB::table('policy_providers')->get()->count() == 0) {
            DB::table('policy_providers')->insert($providers);
        } else {
            echo "policy_providers table is not empty.";
        }
    }
}
