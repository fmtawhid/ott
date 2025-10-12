<?php

namespace Modules\Subscriptions\database\seeders;

use Illuminate\Database\Seeder;

class SubscriptionsTransactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subscriptions_transactions')->delete();
        
        \DB::table('subscriptions_transactions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'subscriptions_id' => 1,
                'user_id' => 3,
                'amount' => 50,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'tax_data'=> NULL,
                'other_transactions_details' => NULL,
                'created_by' => 3,
                'updated_by' => 3,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:33:46',
                'updated_at' => '2024-07-15 09:33:46',
            ),
            1 => 
            array (
                'id' => 2,
                'subscriptions_id' => 2,
                'user_id' => 4,
                'amount' => 5,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'tax_data'=> NULL,
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'other_transactions_details' => NULL,
                'created_by' => 4,
                'updated_by' => 4,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:37:23',
                'updated_at' => '2024-07-15 09:37:23',
            ),
            2 => 
            array (
                'id' => 3,
                'subscriptions_id' => 3,
                'user_id' => 5,
                'amount' => 20,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'tax_data'=> NULL,
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'other_transactions_details' => NULL,
                'created_by' => 5,
                'updated_by' => 5,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:39:02',
                'updated_at' => '2024-07-15 09:39:02',
            ),
            3 => 
            array (
                'id' => 4,
                'subscriptions_id' => 4,
                'user_id' => 6,
                'amount' => 50,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'tax_data'=> NULL,
                'other_transactions_details' => NULL,
                'created_by' => 6,
                'updated_by' => 6,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:41:37',
                'updated_at' => '2024-07-15 09:41:37',
            ),
            4 => 
            array (
                'id' => 5,
                'subscriptions_id' => 5,
                'user_id' => 8,
                'amount' => 80,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'tax_data'=> NULL,
                'other_transactions_details' => NULL,
                'created_by' => 8,
                'updated_by' => 8,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:44:11',
                'updated_at' => '2024-07-15 09:44:11',
            ),
            5 => 
            array (
                'id' => 6,
                'subscriptions_id' => 6,
                'user_id' => 9,
                'amount' => 80,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'tax_data'=> NULL,
                'other_transactions_details' => NULL,
                'created_by' => 9,
                'updated_by' => 9,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:45:47',
                'updated_at' => '2024-07-15 09:45:47',
            ),
            6 => 
            array (
                'id' => 7,
                'subscriptions_id' => 7,
                'user_id' => 10,
                'amount' => 5,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'tax_data'=> NULL,
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'other_transactions_details' => NULL,
                'created_by' => 10,
                'updated_by' => 10,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:46:34',
                'updated_at' => '2024-07-15 09:46:34',
            ),
            7 => 
            array (
                'id' => 8,
                'subscriptions_id' => 8,
                'user_id' => 14,
                'amount' => 20,
                'payment_type' => 'stripe',
                'payment_status' => 'paid',
                'transaction_id' => 'pi_1OnGh1FTMa5P8ht0pEWTz',
                'tax_data'=> NULL,
                'other_transactions_details' => NULL,
                'created_by' => 14,
                'updated_by' => 14,
                'deleted_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-07-15 09:48:17',
                'updated_at' => '2024-07-15 09:48:17',
            ),
        ));
        
        
    }
}