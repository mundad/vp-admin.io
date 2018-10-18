<?php

namespace App\Admin\Controllers;

use App\ComDep;
use App\Company;
use App\Http\Controllers\Controller;
use App\ServiceType;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;


class ComDepController extends Controller
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
        return Admin::grid(ComDep::class, function (Grid $grid) {

            $grid->id('Id');
            $grid->alias('Alias');
            $grid->name('Name');
            $grid->company_id('Company')->display(function($id) {
                return Company::find($id)->name;
            });
            $grid->id_com_dep_admin('Company department admin')->display(function($id) {
                return Admin::user()->find($id)->name;
            });
            $grid->service_type_id('Service type')->display(function($id) {
                return ServiceType::find($id)->name;
            });
            $grid->info('Info');
            $grid->info_for_vp_admin('Info for vp admin');
            $grid->address('Address');
            $grid->info_station('Info station');
            $grid->telephone('Telephone');
            $grid->e_mail('E mail');
            $grid->class('Class');
            $grid->created_at('Created at');
            $grid->updated_at('Updated at');
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
        $show = new Show(ComDep::findOrFail($id));

        $show->id('Id');
        $show->alias('Alias');
        $show->name('Name');
        $show->company_id('Company id');
        $show->id_com_dep_admin('Id com dep admin');
        $show->service_type_id('Service type id');
        $show->id_admin_add('Id admin add');
        $show->info('Info');
        $show->info_for_vp_admin('Info for vp admin');
        $show->address('Address');
        $show->info_station('Info station');
        $show->telephone('Telephone');
        $show->e_mail('E mail');
        $show->class('Class');
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
        $form = new Form(new ComDep);

        $form->text('alias', 'Alias');
        $form->text('name', 'Name');
        $form->select('company_id', 'Company')->options($this->optcom);
        $form->select('id_com_dep_admin', 'Company department admin')->options($this->optcomdep);
        $form->select('service_type_id', 'Service type')->options($this->optsertype);
        $form->textarea('info', 'Info');
        $form->textarea('info_for_vp_admin', 'Info for vp admin');
        $form->text('address', 'Address');
        $form->textarea('info_station', 'Info station');
        $form->text('telephone', 'Telephone');
        $form->text('e_mail', 'E mail');
        $form->text('class', 'Class');$form->saving(function (Form $form) {
             $form->model()->id_admin_add=Admin::user()->id;
        });

        return $form;
    }
    public $optcom,$optcomdep,$optsertype;
    public function opt(){
        if(empty($this->optcom))$this->optcom=Company::all()->pluck('name','id');
        if(empty($this->optcomdep))$this->optcomdep=Admin::user()->all()->pluck('name','id');
        if(empty($this->optsertype))$this->optsertype=ServiceType::all()->pluck('name','id');
    }
}
