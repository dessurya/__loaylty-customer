<?php

use Illuminate\Database\Seeder;
use App\Models\Config;

class SeederConfig extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$datas = [
    		[
    			"key" => "User",
    			"config" => '{
    				"page_pattern" : "pages.pattern_index_dtable",
    				"models" : "User",
    				"table_models" : "User",
    				"form_route" : "user.form",
    				"form_target" : "#UserForm",
    				"form_readonly" : [],
    				"form_required" : ["name","email"],
    				"pass_param" : {
	    				"page_title" : "User Management",
	    				"form_location" : "pages.user_form",
	    				"form_config" : {
		    				"id" : "UserForm",
		    				"title" : "User Form",
		    				"action" : "user.store"
	    				},
	    				"table_url" : "user.cdt",
	    				"table_config" : [
	    					{"data":"name","name":"name","searchable":true,"orderable":true},
	    					{"data":"email","name":"email","searchable":true,"orderable":true}
	    				],
	    				"button_action" : [
	    					{"route" : "user.reset.password", "title" : "Reset Password User", "action" : "reset", "select" : "true", "confirm" : "true", "multiple" : "true", "icon" : "undo"},
	    					{"route" : "user.form", "title" : "Add User", "action" : "add", "select" : "false", "confirm" : "false", "multiple" : "false", "icon" : "plus-square"},
	    					{"route" : "user.form", "title" : "View/Update User", "action" : "view", "select" : "true", "confirm" : "false", "multiple" : "false", "icon" : "folder-open"},
	    					{"route" : "user.delete", "title" : "Delete User", "action" : "delete", "select" : "true", "confirm" : "true", "multiple" : "true", "icon" : "trash-alt"}
	    				]
    				}
    			}'
    		],
    		[
    			"key" => "MasterWebsite",
    			"config" => '{
    				"page_pattern" : "pages.pattern_index_dtable",
    				"models" : "MasterWebsite",
    				"table_models" : "MasterWebsite",
    				"form_route" : "master.website.form",
    				"form_target" : "#MasterWebsite",
    				"form_readonly" : [],
    				"form_required" : ["code","name"],
    				"pass_param" : {
	    				"page_title" : "Master Website Management",
	    				"form_location" : "pages.masterWebsite_form",
	    				"form_config" : {
		    				"id" : "MasterWebsite",
		    				"title" : "Master Website",
		    				"action" : "master.website.store"
	    				},
	    				"table_url" : "master.website.cdt",
	    				"table_config" : [
	    					{"data":"name","name":"name","searchable":true,"orderable":true},
	    					{"data":"code","name":"code","searchable":true,"orderable":true}
	    				],
	    				"button_action" : [
	    					{"route" : "master.website.form", "title" : "Add Master Website", "action" : "add", "select" : "false", "confirm" : "false", "multiple" : "false", "icon" : "plus-square"},
	    					{"route" : "master.website.form", "title" : "View/Update Master Website", "action" : "view", "select" : "true", "confirm" : "false", "multiple" : "false", "icon" : "folder-open"},
	    					{"route" : "master.website.delete", "title" : "Delete Master Website", "action" : "delete", "select" : "true", "confirm" : "true", "multiple" : "true", "icon" : "trash"}
	    				]
    				}
    			}'
    		],
    		[
    			"key" => "MasterBank",
    			"config" => '{
    				"page_pattern" : "pages.pattern_index_dtable",
    				"models" : "MasterBank",
    				"table_models" : "MasterBank",
    				"form_route" : "master.bank.form",
    				"form_target" : "#MasterBank",
    				"form_readonly" : [],
    				"form_required" : ["code","name"],
    				"pass_param" : {
	    				"page_title" : "Master Bank Management",
	    				"form_location" : "pages.masterBank_form",
	    				"form_config" : {
		    				"id" : "MasterBank",
		    				"title" : "Master Bank",
		    				"action" : "master.bank.store"
	    				},
	    				"table_url" : "master.bank.cdt",
	    				"table_config" : [
	    					{"data":"name","name":"name","searchable":true,"orderable":true},
	    					{"data":"code","name":"code","searchable":true,"orderable":true}
	    				],
	    				"button_action" : [
	    					{"route" : "master.bank.form", "title" : "Add Master Bank", "action" : "add", "select" : "false", "confirm" : "false", "multiple" : "false", "icon" : "plus-square"},
	    					{"route" : "master.bank.form", "title" : "View/Update Master Bank", "action" : "view", "select" : "true", "confirm" : "false", "multiple" : "false", "icon" : "folder-open"},
	    					{"route" : "master.bank.delete", "title" : "Delete Master Bank", "action" : "delete", "select" : "true", "confirm" : "true", "multiple" : "true", "icon" : "trash"}
	    				]
    				}
    			}'
    		],
    		[
    			"key" => "MasterTier",
    			"config" => '{
    				"page_pattern" : "pages.pattern_index_dtable",
    				"models" : "MasterTier",
    				"table_models" : "MasterTier",
    				"form_route" : "master.tier.form",
    				"form_target" : "#MasterTier",
    				"form_readonly" : [],
    				"form_required" : ["name"],
    				"pass_param" : {
	    				"page_title" : "Master Tier Management",
	    				"form_location" : "pages.masterTier_form",
	    				"form_config" : {
		    				"id" : "MasterTier",
		    				"title" : "Master Tier",
		    				"action" : "master.tier.store"
	    				},
	    				"table_url" : "master.tier.cdt",
	    				"table_config" : [
	    					{"data":"name","name":"name","searchable":true,"orderable":true},
	    					{"data":"icon","name":"icon","searchable":false,"orderable":false}
	    				],
	    				"button_action" : [
	    					{"route" : "master.tier.form", "title" : "Add Master Tier", "action" : "add", "select" : "false", "confirm" : "false", "multiple" : "false", "icon" : "plus-square"},
	    					{"route" : "master.tier.form", "title" : "View/Update Master Tier", "action" : "view", "select" : "true", "confirm" : "false", "multiple" : "false", "icon" : "folder-open"},
	    					{"route" : "master.tier.delete", "title" : "Delete Master Tier", "action" : "delete", "select" : "true", "confirm" : "true", "multiple" : "true", "icon" : "trash"}
	    				]
    				}
    			}'
    		],
    		[
    			"key" => "Customer",
    			"config" => '{
    				"page_pattern" : "pages.pattern_customer_index_dtable",
    				"models" : "Customer",
    				"table_models" : "Customer",
    				"form_route" : "customer.form",
    				"form_target" : "#Customer",
    				"form_readonly" : ["code"],
    				"form_required" : ["username","name","alamat","no_hp","no_rekening","atas_nama_rekening","website_id","bank_id","tier_id"],
    				"import_header_validat" : ["username","name","alamat","no_hp","no_rekening","atas_nama_rekening","website_code","bank_code","tier"],
    				"pass_param" : {
	    				"page_title" : "Customer Management",
	    				"form_location" : "pages.customer_form",
	    				"form_config" : {
		    				"id" : "Customer",
		    				"title" : "Customer",
		    				"action" : "customer.store"
	    				},
	    				"import_url" : "customer.import",
	    				"table_url" : "customer.cdt",
	    				"table_config" : [
	    					{"data":"code","name":"code","searchable":true,"orderable":true},
	    					{"data":"username","name":"username","searchable":true,"orderable":true},
	    					{"data":"name","name":"name","searchable":true,"orderable":true},
	    					{"data":"alamat","name":"alamat","searchable":true,"orderable":true},
	    					{"data":"no_hp","name":"no_hp","searchable":true,"orderable":true},
	    					{"data":"no_rekening","name":"no_rekening","searchable":true,"orderable":true},
	    					{"data":"atas_nama_rekening","name":"atas_nama_rekening","searchable":true,"orderable":true},
	    					{"data":"website","name":"website","searchable":true,"orderable":true},
	    					{"data":"bank","name":"bank","searchable":true,"orderable":true},
	    					{"data":"tier","name":"tier","searchable":true,"orderable":true}
	    				],
	    				"button_action" : [
	    					{"route" : "customer.form", "title" : "Add Customer", "action" : "add", "select" : "false", "confirm" : "false", "multiple" : "false", "icon" : "plus-square"},
	    					{"route" : "customer.form", "title" : "View/Update Customer", "action" : "view", "select" : "true", "confirm" : "false", "multiple" : "false", "icon" : "folder-open"},
	    					{"route" : "customer.delete", "title" : "Delete Customer", "action" : "delete", "select" : "true", "confirm" : "true", "multiple" : "true", "icon" : "trash"}
	    				]
    				}
    			}'
    		]
    	];

    	foreach ($datas as $data) {
    		Config::create($data);
    	}
    }
}
