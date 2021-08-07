<div class="modal fade" id="addModal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center">Create Menu Item</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" id="menuItemForm">
            <input type="hidden" name="id" form="menuItemForm">
                            <div class="box-body">
                                @csrf
                                    <div class="form-group">
                                        <label for="menu_name" class="col-sm-3" >Menu name</label>                                         
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" autofocus form="menuItemForm" name="name">  
                                        </div>  
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-sm-3" >File input</label>
                                        <div class="col-sm-9">
                                        <input type="file" id="imageUpload">
                                        <input type="hidden" id="64baseimage" name="main_image">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="menu_categories" class="col-sm-3" >Menu Categories</label>
                                        <div class="col-sm-9">
                                        <select class="form-control select2" id="menu_category"  name="menu_category">
                                            @foreach($menuCategory as $key=> $category)
                                               <option  value="{{$category->id}}">{{$category->name}}</option>                                             
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="menu_categories" class="col-sm-3" >Menu oprions Categories</label>
                                        <div class="col-sm-9">
                                        <select class="form-control select2" id="menu_categories">
                                            @foreach($menuoptioncategories as $key=> $category)
                                               <option data-index={{$key}} value="{{$category->id}}">{{$category->name}}</option>                                             
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    

                                    <div class="form-group">
                                        <label for="menu_options" class="col-sm-3" >Menu options</label>
                                        <div class="col-sm-9">
                                        <select  class="form-control select2" id="menu_options">
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="col-sm-3" >Selected</label>
                                        <div class="col-sm-9">
                                          <button type="button" class="btn btn-primary"  onclick="addOption()">Add</button>
                                          <table style="width:100%" id="item-table">
                                          </table>
                                        </div>             
                                    </div>

                                    <div class="form-group">
                                        <label for="price" class="col-sm-3" >Price</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="price" name="price"> 
                                        </div>             
                                    </div>

                                    <div class="form-group">
                                        <label for="qty" class="col-sm-3" >Qty</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="qty" name="qty">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="menuItemFormErrors"> </div>
                            <!-- /.box-body -->
                        </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" form="noForm" class="btn btn-primary FormSubmit" data-form="menuItemForm">Save</button>
            </div>
        </div>
    <!-- /.modal-content -->
   </div>
          <!-- /.modal-dialog -->
</div>
