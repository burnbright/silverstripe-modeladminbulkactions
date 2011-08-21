<?php

class ModelAdminBulkActions_CollectionController extends ModelAdmin_CollectionController{

	/**
	 * Overrides parent ResultsForm to add custom actions.
	 * @see ModelAdmin_CollectionController::ResultsForm()
	 */
	public function ResultsForm($searchCriteria){
		$form = parent::ResultsForm($searchCriteria);
		if($customactions = singleton($this->modelClass)->stat('modeladmin_actions')){
			$form->Fields()->insertAfter(new InlineFormAction("customAction","Perform Action on Results"), "SearchResultsHeader");
			$form->Fields()->insertAfter(new DropdownField("action","Action",$customactions), "SearchResultsHeader");
		}
		return $form;
	}

	/**
	 * Tries running the custom action on a singleton of the object, or this controller.
	 * @param array $data
	 * @param array $form
	 * @return multitype:
	 */
	function customAction($data,$form){

		if(isset($data['action'])){
			if(method_exists($this,$data['action'])){
				return $this->{$data['action']}($data);
			}elseif(method_exists($this->parentController,$data['action'])){
				return $this->parentController->{$data['action']}($data);
			}
			//TODO: could provide result set looping, and calling action on each record controller.
		}

		FormResponse::error("Action not found");
		FormResponse::respond();
		return;
	}

	function bulkrun($action){
		foreach($results as $result){
			$result->{$action}();
		}
	}

}