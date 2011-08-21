<?php

class ModelAdminBullkActionsDecorator extends Extension{

	function onAfterInit(){
		Requirements::javascript("modeladminbulkactions/javascript/bulkactions.js");
		Requirements::css("modeladminbulkactions/css/bulkactions.css");
	}

}