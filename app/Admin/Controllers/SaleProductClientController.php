<?php

namespace App\Admin\Controllers;

use App\Client;
use App\Country;
use App\Http\Controllers\Controller;
use App\Product;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;

class SaleProductClientController extends Controller
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
        return redirect('/admin/client_cart/create');
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
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $this->option();
        $form = new Form(new Client);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableList();
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->text('first_name', 'First name');
        $form->text('second_name', 'Second name');
        $form->text('company', 'Company');
        $form->text('address_line_1', 'Address line 1');
        $form->text('address_line_2', 'Address line 2');
        $form->text('city', 'City');
        $form->mobile('telephone', 'Telephone');
        $form->email('e_mail', 'E mail');
        $form->select('country_id', 'Country')->options(Country::all()->pluck('name','id'));
        $form->html('
                    <span id="copy1">
                        <div class="col-md-5" >
                             <label>Select product</label>
                             <select name = "product[]" class = "form-control">'.$this->option_prod .'</select>
                        </div>
                        <div class="col-md-2">
                            <label>Adult</label>
                            <input name = "adult[]" type = "number" min = "0" max = "99" class = "form-control" value="0">
                        </div>
                        <div class="col-md-2">
                            <label>Child</label>
                            <input name = "child[]" type = "number" min = "0" max = "99" class = "form-control" value="0">
                        </div>
                    </span>
                    <div class="col-md-2">
                        <label>Add line</label>
                        <input type = "button" value = "+" onclick = "addRow()" class = "col-lg-6">
                        <input type = "button" value = "-"  class = "col-lg-6" disabled>
                    </div>
                    <br>
                    <div id = "contentd">
                    
                    </div>',
                    'Buy product');
        $form->saving(function ($form) {
            $prod=array();
            foreach ($form->product as $item){
                $id=Product::where('name',$item)->first()->id;
                if(!$id) $this->er_message=$this->er_message.'Product select error';
                else array_push($prod,$id);
            }
            if(!empty($er_message)) {
                return $this->return_error($this->er_message);
            }
            $sum=0;
            $check_a_c=0;
            for ($i=0;$i<count($form->product);$i++){
                $item_a=$form->adult[$i];
                $item_c=$form->child[$i];
                // if all massiv zero
                $sum=$item_a+$item_c+$sum;

                if($item_a<0||$item_a>99||!is_int($item_a))$check_a_c++;
                if($item_c<0||$item_c>99||!is_int($item_c))$check_a_c++;
            }
            if($sum>0||$check_a_c>0){
                $this->er_message=$this->er_message.'Count adult or child type wrong';
                return $this->return_error($this->er_message);
            }
            DB::beginTransaction();
            try{

                DB::commit();
                return $this->successful_insert();
            }catch (Exception $e) {
                DB::rollBack();
                $this->er_message=$this->er_message.' '.$e;
                return $this->return_error($this->er_message);
            }
        });
        $form->saved(function (Form $form) {

        });
        return $form;
    }

    public $er_message='';
    public function return_error($message){
        $error = new MessageBag([
            'title'   => 'ERROR',
            'message' => $message,
        ]);
        return back()->with(compact('error'));
    }
    public function successful_insert(){
        admin_success('Buy PASS', 'SUCCESSFUL');
    }
    public $option_prod="";
    public function option(){
        $prod=Product::all('name');
        foreach ($prod as $item){
            $this->option_prod=$this->option_prod.'<option>'.$item->name.'</option>';
        }
    }
}
