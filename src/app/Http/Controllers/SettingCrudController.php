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
        $this->crud->entity_name = "setting";
		$this->crud->entity_name_plural = "settings";
		$this->crud->route = "admin/setting";
		$this->crud->permissions = ['list', 'edit'];
		$this->crud->reorder = false;
		$this->crud->reorder_label = "name";

		$this->crud->columns = [
							[
								'name' => 'name',
								'label' => "Name"
							],
							[
								'name' => 'value',
								'label' => "Value"
							],
							[
								'name' => 'description',
								'label' => "Description"
							],
					];

		$this->crud->fields = [
								[
									'name' => 'name',
									'label' => 'Name',
									'type' => 'text',
									'disabled' => 'disabled'
								],
								[
									'name' => 'value',
									'label' => 'Value',
									'type' => 'text'
								],
							];
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
		$this->crud->hasPermissionOrFail('list');

		$this->crud->query = $this->crud->model->where('active', 1)->select('*'); // <---- this is where it's different

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
