<?php

class AllPapersView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "All Papers";
		$this->data->pageHeading = "All Papers";
		$this->setActiveNavLink("Papers", "All");
		$this->data->searchEndpoint = "papers";
		$this->data->searchUrl = "papers/search";
		//filters
		$countries = SysDataList::get('countries-en');
		$languages = SysDataList::get('languages-en');
		$regions = SysDataList::get('regions');
		$areaOptions = array_keys(PaperGroup::getValues());
		$areaLabels = array_values(PaperGroup::getValues());
		$levelOptions = array_keys(PaperLevel::getValues());
		$levelLabels = array_values(PaperLevel::getValues());
		$statusOptions = [
				Paper::STATUS_ACCEPTED,
				Paper::STATUS_COMMUNICATIONS,
				Paper::STATUS_GRACE_PERIOD,
				Paper::STATUS_PENDING,
				Paper::STATUS_PIPELINE,
				Paper::STATUS_POST_WORKSHOP_REVIEW_MIN,
				Paper::STATUS_POST_WORKSHOP_REVISION_MAJ,
				Paper::STATUS_POST_WORKSHOP_REVISION_MIN,
				Paper::STATUS_REJECTED,
				Paper::STATUS_REVIEW,
				Paper::STATUS_REVIEW_REVISION_MAJ,
				Paper::STATUS_REVIEW_REVISION_MIN,
				Paper::STATUS_REVIEW_SUBMITTED,
				Paper::STATUS_VETTING,
				Paper::STATUS_VETTING_REVISION,
				Paper::STATUS_WORKSHOP_QUEUE,
		];
		$statusLabels = array_map(function($status){ return Paper::getStatusStringStatic($status); }, $statusOptions);
		$filters = [
				[
					"label"=>"Country of Research",
					"type"=>"select",
					"name"=>"country",
					"options"=> $countries,
					"optionLabels"=> $countries						
				],
				[
					"label"	=> "Region",
					"type" => "select",
					"name" => "region",
					"options" => $regions,
					"optionLabels"=> $regions
				],
				[
					"label"=>"Language",
					"type"=>"select",
					"name"=>"language",
					"options"=> $languages,
					"optionLabels"=> $languages
				],
				[
					"label"=>"Thematic Area",
					"type"=>"select",
					"name"=>"thematic_area",
					"options"=> $areaOptions,
					"optionLabels"=> $areaLabels
				],
				[
					"label"=>"Level",
					"type"=>"select",
					"name"=>"level",
					"options"=> $levelOptions,
					"optionLabels"=> $levelLabels
				],
				[
					"label"=>"Status",
					"type"=>"select",
					"name"=>"status",
					"options"=> $statusOptions,
					"optionLabels"=> $statusLabels
				]
		];
		$this->data->filters = $filters;
		$this->data->recordsTable = $this->read("papers-table");
		$this->data->pageContent = $this->read("records-table-container");
		
		$this->showBase();
	}
}