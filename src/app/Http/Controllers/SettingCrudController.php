<?php namespace Backpack\Settings\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION
use Backpack\Settings\app\Http\Requests\SettingRequest as StoreRequest;
use Backpack\Settings\app\Http\Requests\SettingRequest as UpdateRequest;

class SettingCrudController extends CrudController {

	public function __construct() {
		parent::__construct();

        $this->crud->setModel("Backpack\Settings\app\Models\Setting");
        $this->crud->setEntityNameStrings('setting', 'settings');
        $this->crud->setRoute('admin/setting');
        $this->crud->denyAccess(['create', 'delete']);
        $this->crud->setColumns(['name', 'value', 'description']);
        $this->crud->addField([
								'name' => 'name',
								'label' => 'Name',
								'type' => 'text',
								'disabled' => 'disabled'
							]);
        $this->crud->addField([
								'name' => 'value',
								'label' => 'Value',
								'type' => 'text'
							]);
	}

	/**
	 * Display all rows in the database for this entity.
	 * This overwrites the default CrudController behaviour:
	 * - instead of showing all entries, only show the "active" ones
	 *
	 * @return Response
	 */
	public function index()
	{
		// if view_table_permission is false, abort
		$this->crud->hasAccessOrFail('list');
		$this->crud->addClause('where', 'active', 1); // <---- this is where it's different from CrudController::index()

		$this->data['entries'] = $this->crud->getEntries();
		$this->data['crud'] = $this->crud;
		$this->data['title'] = ucfirst($this->crud->entity_name_plural);

		// load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
		return view('crud::list', $this->data);
	}

	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
