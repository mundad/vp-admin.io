<?php

namespace App\Admin\Controllers;

use App\Product;
use App\Sale;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SaleController extends Controller
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
        $grid = new Grid(new Sale);

        $grid->id('Id');
        $grid->qrcode_id('Qrcode id');
        $grid->product_id('Product')->display(function($id) {
            return Product::find($id)->name;
        });
        $grid->id_admin_add_card('Admin add card')->display(function($id) {
            if($id<>0){
                 return Admin::user()->find($id)->name;}
            else{ return '0';}
        });
        $grid->defrayment_id('Defrayment id');
        $grid->start_date('Start date');
        $grid->count_visit('Count visit');
        $grid->limit('Limit');
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
        $show = new Show(Sale::findOrFail($id));

        $show->id('Id');
        $show->qrcode_id('Qrcode');
        $show->product_id('Product');
        $show->id_admin_add_card('Admin add card');
        $show->defrayment_id('Defrayment id');
        $show->start_date('Start date');
        $show->count_visit('Count visit');
        $show->limit('Limit');
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
        $form = new Form(new Sale);

        $form->text('qrcode_id', 'Qrcode')->attribute(' readonly');
        $form->text('product_id', 'Product')->attribute(' readonly');
        $form->text('id_admin_add_card', 'Admin add card')->attribute(' readonly');
        $form->text('defrayment_id', 'Defrayment id')->attribute(' readonly');
        $form->date('start_date', 'Start date')->attribute(' readonly');
        $form->number('count_visit', 'Count visit');
        $form->number('limit', 'Limit');

        return $form;
    }
}
