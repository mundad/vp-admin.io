<?php

namespace App\Admin\Controllers;

use App\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Part;
use Encore\Admin\Facades\Admin;

class ProductController extends Controller
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
        $grid = new Grid(new Product);

        $grid->id('Id');
        $grid->alias('Alias');
        $grid->name('Name');
        $grid->info('Info');
        $grid->price_adult('Price adult');
        $grid->price_child('Price child');
        $grid->part_id('Part')->display(function($id) {
            return Part::find($id)->name;
        });
        $grid->days_active('Days active');
        $grid->days_after_activation('Days after activation');
        $grid->attracton('Attracton');
        $grid->limit_com_services('Limit company services');
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
        $show = new Show(Product::findOrFail($id));

        $show->id('Id');
        $show->alias('Alias');
        $show->name('Name');
        $show->info('Info');
        $show->price_adult('Price adult');
        $show->price_child('Price child');
        $show->id_admin_add('Id admin add');
        $show->part_id('Part id');
        $show->days_active('Days active');
        $show->days_after_activation('Days after activation');
        $show->attracton('Attracton');
        $show->limit_com_services('Limit com services');
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
        $form = new Form(new Product);

        $form->text('alias', 'Alias');
        $form->text('name', 'Name');
        $form->textarea('info', 'Info');
        $form->currency('price_adult', 'Price adult')->symbol('$');
        $form->currency('price_child', 'Price child')->symbol('$');
        $form->select('part_id', 'Part')->options($this->optpart);
        $form->number('days_active', 'Days active')->default(30);
        $form->number('days_after_activation', 'Days after activation')->default(1);
        $form->number('attracton', 'Attracton');
        $form->switch('limit_com_services', 'Limit company services for attraction mode');
        $form->saving(function (Form $form) {
            $form->model()->id_admin_add=Admin::user()->id;
        });
        return $form;
    }
    public $optpart;
    public function opt(){
        if(empty($this->optpart))$this->optpart=Part::all()->pluck('name','id');
    }
}
