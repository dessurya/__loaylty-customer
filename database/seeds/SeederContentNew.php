<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\MasterWebsite;
use App\Models\MasterBank;
use App\Models\MasterTier;

class SeederContentNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$datas = [
    		[ "name" => "admin001", "email" => "admin001@mail.com", "password" => "asdasd" ],
    		[ "name" => "admin002", "email" => "admin002@mail.com", "password" => "admin002" ],
    		[ "name" => "admin003", "email" => "admin003@mail.com", "password" => "admin003" ],
    		[ "name" => "admin004", "email" => "admin004@mail.com", "password" => "admin004" ],
    		[ "name" => "admin005", "email" => "admin005@mail.com", "password" => "admin005" ]
    	];
    	foreach ($datas as $data) {
    		$store = User::create($data);
    	}

        $datas = [
            [ "code" => "qwe", "name" => "qwertyuiop"],
            [ "code" => "asd", "name" => "asdfghjkl"],
            [ "code" => "zxc", "name" => "zxcvbnm"]
        ];
        foreach ($datas as $data) {
            $store = MasterWebsite::create($data);
        }

        $datas = [
            [ "code" => "001", "name" => "bank001"],
            [ "code" => "002", "name" => "bank002"],
            [ "code" => "003", "name" => "bank003"]
        ];
        foreach ($datas as $data) {
            $store = MasterBank::create($data);
        }

        $datas = [
            [ "name" => "Tier01"],
            [ "name" => "Tier02"],
            [ "name" => "Tier03"],
            [ "name" => "Tier04"]
        ];
        foreach ($datas as $data) {
            $store = MasterTier::create($data);
        }

        $datas = [
            [
                "username" => "custm01",
                "name" => "customer 001",
                "alamat" => "alamat customer 001",
                "no_hp" => "082828618283",
                "no_rekening" => "082828618283",
                "atas_nama_rekening" => "customer 001",
                "website_id" => "1",
                "bank_id" => "1",
                "tier_id" => "1"
            ],
            [
                "username" => "custm02",
                "name" => "customer 002",
                "alamat" => "alamat customer 002",
                "no_hp" => "082828628283",
                "no_rekening" => "082828628283",
                "atas_nama_rekening" => "customer 002",
                "website_id" => "2",
                "bank_id" => "2",
                "tier_id" => "2"
            ],
            [
                "username" => "custm03",
                "name" => "customer 003",
                "alamat" => "alamat customer 003",
                "no_hp" => "083838638383",
                "no_rekening" => "083838638383",
                "atas_nama_rekening" => "customer 003",
                "website_id" => "3",
                "bank_id" => "3",
                "tier_id" => "3"
            ]
        ];
        foreach ($datas as $data) {
            $store = Customer::create($data);
        }
        $loop = Customer::get();
        foreach ($loop as $data) {
            $data->code = $data->code.$data->id;
            $data->save();
        }
    }
}
