<?php

namespace App\Admin\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\ComCity;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;

class CompanyController extends Controller
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
        return Admin::grid(Company::class, function (Grid $grid) {
            $grid->id('Id')->sortable();
            $grid->alias('Alias');
            $grid->name('Name');
            $grid->info('Info');
            $grid->info_for_vp_admin('Info for vp admin');
            $grid->city_id('City')->display(function($id_cities) {
                return ComCity::find($id_cities)->name;
            });
            $grid->percent('Percent');
            $grid->id_com_admin('Id com admin');
            $grid->telephone('Telephone');
            $grid->web_site('Web site');
            $grid->created_at('Created at');
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Company::findOrFail($id));

        $show->id('Id');
        $show->alias('Alias');
        $show->name('Name');
        $show->id_admin_add('Id admin add');
        $show->info('Info');
        $show->info_for_vp_admin('Info for vp admin');
        $show->city_id('Id city');
        $show->percent('Percent');
        $show->id_com_admin('Id com admin');
        $show->telephone('Telephone');
        $show->web_site('Web site');
        $show->e_mail('E mail');
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
        $form = new Form(new Company);
        $options = Administrator::where('id', '!=',Admin::user()->id )->get()->pluck('name', 'id');
        $form->text('alias', 'Alias')->rules('required');
        $form->text('name', 'Name');
        $form->textarea('info', 'Info');
        $form->textarea('info_for_vp_admin', 'Info for vp admin');
        $form->number('percent', 'Percent');
        $form->select('id_com_admin','company_admin')->options($options);
        $form->text('telephone', 'Telephone');
        $form->text('web_site', 'Web site');
        $form->text('e_mail', 'E mail');
        $form->select('city_id', trans('company_cities'))->options($this->opCity());
        $form->saving(function (Form $form) {
            $form->model()->id_admin_add=Admin::user()->id;
        });

        return $form;
    }
    protected $optionCity="";
    public function opCity(){
        if(empty($this->optionCity)) $this->optionCity=ComCity::all()->pluck('name', 'id');
        return $this->optionCity;
    }
}
