<?php

namespace App\Admin\Controllers;

use App\ComService;
use App\Http\Controllers\Controller;
use App\Part;
use App\ComDep;
use App\Company;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class ComServiceController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ComService);

        $grid->id('Id');
        $grid->alias('Alias');
        $grid->name('Name');
        $grid->company_id('Company')->display(function($id) {
            return Company::find($id)->name;
        });
        $grid->part_id('Part')->display(function($id) {
            return Part::find($id)->name;
        });
        $grid->com_dep_id('Company department')->display(function($id) {
            return ComDep::find($id)->name;
        });
        $grid->info('Info');
        $grid->price_adult('Price adult');
        $grid->price_child('Price child');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ComService::findOrFail($id));

        $show->id('Id');
        $show->alias('Alias');
        $show->company_id('Company id');
        $show->id_admin_add('Id admin add');
        $show->part_id('Part id');
        $show->com_dep_id('Com dep id');
        $show->name('Name');
        $show->info('Info');
        $show->price_adult('Price adult');
        $show->price_child('Price child');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $this->opt();
        $form = new Form(new ComService);

        $form->text('alias', 'Alias');
        $form->select('company_id', 'Company')->options($this->optcom);
        $form->select('part_id', 'Part')->options($this->optpart);
        $form->select('com_dep_id', 'Company department')->options($this->optcomdep);
        $form->text('name', 'Name');
        $form->textarea('info', 'Info');
        $form->currency('price_adult', 'Price adult')->symbol('$');;
        $form->currency('price_child', 'Price child')->symbol('$');;
        $form->saving(function (Form $form) {
            $form->model()->id_admin_add=Admin::user()->id;
        });

        return $form;
    }
    public $optcom,$optpart,$optcomdep;
    public function opt(){
        if(empty($this->optcom))$this->optcom=Company::all()->pluck('name','id');
        if(empty($this->optcomdep))$this->optcomdep=ComDep::all()->pluck('name','id');
        if(empty($this->optpart))$this->optpart=Part::all()->pluck('name','id');
    }
}
