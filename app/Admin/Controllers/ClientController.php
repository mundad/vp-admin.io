<?php

namespace App\Admin\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Country;

class ClientController extends Controller
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
        $grid = new Grid(new Client);

        $grid->id('Id');
        $grid->first_name('First name');
        $grid->second_name('Second name');
        $grid->company('Company');
        $grid->address_line_1('Address line 1');
        $grid->address_line_2('Address line 2');
        $grid->city('City');
        $grid->telephone('Telephone');
        $grid->e_mail('E mail');
        $grid->country_id('Country')->display(function($id){
            return Country::find($id)->name;
        });
        $grid->status('Status');
        $grid->stripe_id('Stripe id');
        $grid->card_brand('Card brand');
        $grid->card_last_four('Card last four');
        $grid->trial_ends_at('Trial ends at');
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
        $show = new Show(Client::findOrFail($id));

        $show->id('Id');
        $show->first_name('First name');
        $show->second_name('Second name');
        $show->company('Company');
        $show->address_line_1('Address line 1');
        $show->address_line_2('Address line 2');
        $show->city('City');
        $show->telephone('Telephone');
        $show->e_mail('E mail');
        $show->country_id('Country id');
        $show->status('Status');
        $show->stripe_id('Stripe id');
        $show->card_brand('Card brand');
        $show->card_last_four('Card last four');
        $show->trial_ends_at('Trial ends at');
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
        $form = new Form(new Client);

        $form->text('first_name', 'First name');
        $form->text('second_name', 'Second name');
        $form->text('company', 'Company');
        $form->text('address_line_1', 'Address line 1');
        $form->text('address_line_2', 'Address line 2');
        $form->text('city', 'City');
        $form->mobile('telephone', 'Telephone');
        $form->text('e_mail', 'E mail');
        $form->select('country_id', 'Country')->options(Country::all()->pluck('name','id'));
        $form->switch('status', 'Status');

        return $form;
    }
}
