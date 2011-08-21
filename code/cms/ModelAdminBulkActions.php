<?php

class ModelAdminBulkActions_CollectionController extends ModelAdmin_CollectionController{

	/**
	 * Overrides parent ResultsForm to add custom actions.
	 * @see ModelAdmin_CollectionController::ResultsForm()
	 */
	public function ResultsForm($searchCriteria){
		$form = parent::ResultsForm($searchCriteria);
		if($customactions = singleton($this->modelClass)->stat('modeladmin_actions')){
			//TODO: only show if there are more than 0 records?
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

		$message = "";
		$code = 200;
		$singleton = singleton($this->modelClass);

		if(isset($data['action']) && $action = $data['action']){

			$count = "";
			if(method_exists($singleton,$action)){
				$count = $this->bulkRun($data);

				$message = sprintf(_t('ModelAdmin.CUSTOMACTION', 'Action "%2$s" has been performed on %3$d %1$s records.'),$singleton->i18n_singular_name(),$action,$count);
			}else{
				$message = "Action '$action' is not available.";
				$code = 404;
			}

			//TODO: allow more cusomisation/control over what outputs, and what to search on (eg: YourModelAdmin)
			//TODO: provide information on how many operations were successful or not

		}else{
			$message = "Action was not found";
			$code = 404;
		}

		$form =  $this->ResultsForm($data);

		return new SS_HTTPResponse($form->forAjaxTemplate(),$code,$message);
	}

	function bulkrun($data){

		if(isset($data['action']) && $action = $data['action']){
			$dataQuery = $this->getSearchQuery($data);
			$records = $dataQuery->execute();
			$sourceClass = $this->modelClass;
			$dataobject = new $sourceClass();
			if($items = $dataobject->buildDataObjectSet($records, 'DataObjectSet')){
				foreach($items as $item){
					$output = $item->{$action}();
					//TODO: do something with output?
				}
				return $items->Count();
			}
		}

		return false;
	}

}