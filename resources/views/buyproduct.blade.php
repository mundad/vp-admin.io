html('
<span id="copy1">
                <div class="col-md-5" >
                     <label>Select product</label>
                     <select name = "product[]" class = "form-control">'. $this->optprod .'</select>
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